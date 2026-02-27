# Features

Overview of the core functionality implemented in Mini LMS.

---

## 🏠 Public Home Page (`/`)

### Course Listing
- Paginated grid displaying all published courses
- 6 courses per page with pagination controls
- Responsive grid: 1 column (mobile) → 2 columns (tablet) → 3 columns (desktop)

### Enrollment Status
- Authenticated users see "Enrolled" badge for enrolled courses
- Dynamic enrollment state fetched via `withExists` query

### Course Metadata
- Level badges (Beginner/Intermediate/Advanced)
- Lesson count per course
- Student enrollment count
- Course title and slug-based URLs

---

## 📖 Course Detail Page (`/courses/{slug}`)

### Course Header Section
- Course title with level badge
- Total lesson count
- Total student count
- Course status indicator

### Lesson List
- Ordered display of all active lessons
- Lesson numbers and titles
- Preview indicator for first lesson
- Locked indicator for non-enrolled users

### Enrollment Card (Livewire Component)
- **Enroll Button**: Blue CTA for non-enrolled users
- **Unenroll Button**: Red option for enrolled users
- **Loading States**: `wire:loading` shows "Processing..." during actions
- **Auth Gate**: Login prompt for guests

### Access Control
- Email verification required for enrollment
- Course must be `active` status
- Cannot enroll in already-enrolled courses

---

## 🎬 Lesson Player (`/courses/{slug}/lessons/{id}`)

### Video Player (Plyr.js)
- Custom video controls with responsive design
- Poster image display before playback
- Keyboard navigation support
- Cross-origin enabled for external video URLs
- Caption/subtitle track support

### Navigation
- Breadcrumb: Courses → Course → Lesson
- Wire navigate for SPA-like transitions
- Active lesson highlighting in sidebar

### Access Policy
- **Preview Lessons**: First lesson accessible without enrollment
- **Enrolled Users**: Full access to all lessons
- **Guests**: Redirected to login for non-preview content

---

## 👤 User Dashboard (`/dashboard`)

### Profile Summary Section
- User name and email display
- Account creation date
- Quick profile edit link

### Recent Enrollments Section
- Paginated list of enrolled courses
- Course thumbnails and metadata
- Progress indicators (if implemented)
- Page name: `enrollments_page`

### Recent Certificates Section
- Paginated list of completed courses
- UUID-based certificate identifiers
- Course title and completion date
- Verifiable credentials

---

## 🔐 Authentication (Laravel Fortify)

### Registration
- Name, email, password fields
- Password confirmation validation
- Automatic email verification sent

### Login
- Email/password authentication
- "Remember me" option
- Rate limiting protection

### Security Features
- Two-factor authentication (2FA) with TOTP
- Recovery codes for account recovery
- Password reset via email link
- Session management

### Profile Management
- Update name and email
- Change password (requires current password)
- Enable/disable 2FA
- Download recovery codes

---

## 🎯 Business Rules

| Action | Rule |
|--------|------|
| Enroll | Auth + verified email + course active + not already enrolled |
| Unenroll | Auth + must be enrolled |
| View Lesson | Auth + enrolled OR lesson is preview |
| Access Dashboard | Auth + verified email |
| Issue Certificate | Course completion tracked via `lesson_progress` |

---

## 🔄 Data Flow

```
User clicks Enroll
    ↓
CourseEnrollmentSection validates via CoursePolicy and check Throttle rate limmter
    ↓
EnrollmentService::enroll() executes in DB transaction
    ↓
Enrollment model created (user_id + course_id)
    ↓
Model event fires CourseEnrolledNotification
    ↓
Queued email sent to user
    ↓
Livewire dispatches 'enrolled' event to UI
```
