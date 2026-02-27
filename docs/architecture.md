# Architecture

Design patterns, service layer, and database structure.

---

## 🏗️ Core Design Patterns

### Base Components

All Livewire components extend base classes for shared functionality:

| Class | Purpose | Location |
|-------|---------|----------|
| `BaseComponent` | Core Livewire component extension | `app/Core/BaseComponent.php` |
| `BaseManagementPaginationComponent` | Pagination with configurable per-page | `app/Core/BaseManagementPaginationComponent.php` |

**Default pagination**: 6 items per page

---

## 🗄️ Database Schema

### Entity Overview

| Entity | Key Features | Soft Deletes |
|--------|--------------|--------------|
| **courses** | Unique slug, status enum, level enum | ✅ |
| **lessons** | Course FK (cascade), order integer, preview flag | ✅ |
| **enrollments** | Composite unique (user_id, course_id) | ✅ |
| **lesson_progress** | started_at, completed_at timestamps | ✅ |
| **certificates** | UUID primary key | ❌ |

### Constraints & Indexes

- `courses.slug` — unique index
- `enrollments` — unique composite on `(user_id, course_id)`
- `lessons.course_id` — foreign key with `cascadeOnDelete`
- `lesson_progress` — tracks individual lesson completion per user

---

## 🔗 Model Relationships

```
User
├── hasMany → Enrollment
├── hasMany → Certificate
└── belongsToMany → Course (as students, via enrollments)

Course
├── hasMany → Lesson (ordered by 'order' column)
├── belongsToMany → User (as students, via enrollments)
└── hasMany → Enrollment

Lesson
└── belongsTo → Course

Enrollment
├── belongsTo → User
├── belongsTo → Course
└── dispatches → CourseEnrolledNotification (on create)

Certificate
├── belongsTo → User
└── belongsTo → Course

LessonProgress
├── belongsTo → User
└── belongsTo → Lesson
```

---

## 🛡️ Authorization (Policies)

### CoursePolicy

| Method | Rule |
|--------|------|
| `enroll($user, $course)` | User authenticated, email verified, course active, not already enrolled |
| `unenroll($user, $course)` | User authenticated and currently enrolled |

### LessonPolicy

| Method | Rule |
|--------|------|
| `view($user, $lesson)` | Authenticated user enrolled in course OR lesson is preview |

---

## ⚙️ Service Layer

### EnrollmentService

Encapsulates all enrollment business logic with transaction safety:

```php
// Enroll user in course
public function enroll(Course $course): Enrollment

// Unenroll user from course
public function unenroll(Course $course): bool

// Check enrollment status
public function isEnrolled(Course $course): bool
```

**Features:**
- Database transactions for data integrity
- Validates course status before enrollment
- Throws `InvalidArgumentException` for auth failures
- Prevents duplicate enrollments via `firstOrCreate`

---

## 📧 Notifications

### BaseNotification

Abstract class for all mail notifications:
- Implements `ShouldQueue` for async delivery
- Uses `Queueable` trait
- Configured for `mail` channel only

### CourseEnrolledNotification

Sent automatically when enrollment is created:
- Subject: "You're enrolled in {course}!"
- Includes personalized greeting
- CTA button linking to course page
- Queued for immediate UI response

---

## 🎯 Enum-backed Values

### StatusEnum

```php
case ACTIVE = 'active';
case INACTIVE = 'inactive';
```

Used by: `Course`, `Lesson`

### CourseLevelEnum

```php
case BEGINNER = 'beginner';
case INTERMEDIATE = 'intermediate';
case ADVANCED = 'advanced';
```

Used by: `Course`

---

## 🔄 Data Integrity

### Soft Deletes

Applied to:
- `Course` — preserves historical enrollment data
- `Lesson` — maintains course structure integrity
- `Enrollment` — retains user activity history
- `LessonProgress` — keeps learning analytics

### Database Transactions

All write operations in services use `DB::transaction()`:
```php
DB::transaction(function () use ($course) {
    // enrollment logic
});
```

---

## 📂 Project Structure

```
app/
├── Core/
│   ├── BaseComponent.php
│   ├── BaseManagementPaginationComponent.php
│   └── Contracts/
├── Enums/
│   ├── StatusEnum.php
│   └── CourseLevelEnum.php
├── Livewire/
│   ├── Course/
│   │   ├── CourseIndex.php
│   │   ├── CourseShow.php
│   │   ├── Lesson/
│   │   │   └── LessonShow.php
│   │   └── Sections/
│   │       ├── CourseContentSection.php
│   │       ├── CourseEnrollmentSection.php
│   │       ├── CourseHeaderSection.php
│   │       └── CourseLevelBadgeSection.php
│   ├── Dashboard/
│   │   ├── Index.php
│   │   └── Sections/
│   │       ├── ProfileSummarySection.php
│   │       ├── RecentCertificatesSection.php
│   │       └── RecentEnrollmentsSection.php
│   └── Actions/
│       └── Logout.php
├── Models/
│   ├── Course.php
│   ├── Lesson.php
│   ├── Enrollment.php
│   ├── LessonProgress.php
│   ├── Certificate.php
│   └── User.php
├── Notifications/
│   ├── BaseNotification.php
│   └── CourseEnrolledNotification.php
├── Policies/
│   ├── CoursePolicy.php
│   └── LessonPolicy.php
└── Services/
    └── EnrollmentService.php
```

---

## 🔐 Security Patterns

| Layer | Implementation |
|-------|---------------|
| **Authorization** | Laravel Policies (`CoursePolicy`, `LessonPolicy`) |
| **Authentication** | Laravel Fortify with 2FA support |
| **CSRF** | Automatic on all forms via `@csrf` |
| **Rate Limiting** | Built into Fortify auth routes |
| **Password Hashing** | Laravel default (bcrypt) |
| **Email Verification** | Required for enrollment actions |
