# Frontend

UI components, behaviors, and frontend technologies.

---

## 🎨 Tech Stack

| Category | Technology | Version |
|----------|------------|---------|
| **CSS Framework** | TailwindCSS | 4.x |
| **Build Tool** | Vite | 7.x |
| **Video Player** | Plyr.js | 3.x |
| **Icons** | Lucide | via Flux UI |
| **UI Components** | Flux UI | Laravel official |
| **Reactive JS** | Alpine.js | 3.x |

---

## 🎬 Video Player (Plyr.js)

### Features

- Responsive embed container with aspect ratio preservation
- Custom poster images before playback
- Keyboard navigation (space, arrows, F for fullscreen)
- Cross-origin support for external video URLs
- Optional caption/subtitle tracks

### Implementation

```blade
<div class="plyr__video-embed" id="plyr-player">
    <video
        id="video-player"
        data-poster="{{ asset('images/video-placeholder.jpg') }}"
        controls
        crossorigin
        playsinline
    >
        <source src="{{ $lesson->video_url }}" type="video/mp4" />
    </video>
</div>
```

### Empty State

When no video is available:
- Centered placeholder with video icon
- "No video available" message
- "Video content will be available soon" subtext

---

## ⚡ Livewire Behaviors

### Loading States

Enrollment buttons show loading indicators during async operations:

```blade
<button wire:click="enroll" wire:loading.attr="disabled">
    <span wire:loading.remove>{{ __('Enroll in Course') }}</span>
    <span wire:loading>{{ __('Enrolling...') }}</span>
</button>
```

### Wire Navigate

SPA-like navigation without full page reloads:

```blade
<a href="{{ route('courses.show', $course->slug) }}" wire:navigate>
    {{ $course->title }}
</a>
```

Used in:
- Course cards linking to detail pages
- Breadcrumb navigation
- Lesson sidebar navigation

---

## 🧩 UI Components

### Course Card

```
┌─────────────────────────────────────┐
│  [Title]                    [Level] │
│  [Enrolled Badge - if applicable]   │
├─────────────────────────────────────┤
│  Lessons: X    Students: Y          │
└─────────────────────────────────────┘
```

Features:
- Hover shadow effect for depth
- Dark mode support (`dark:bg-zinc-800`)
- Responsive grid placement

### Enrollment Card

Sticky sidebar component with dynamic CTA:

| State | Button | Color |
|-------|--------|-------|
| Guest | "Login to Enroll" | Outline blue |
| Not Enrolled | "Enroll in Course" | Solid blue |
| Enrolled | "Unenroll from Course" | Solid red |
| Processing | "Processing..." | Disabled |

### Level Badge Section

Dynamic badge colors based on course level:

| Level | Color |
|-------|-------|
| Beginner | Green |
| Intermediate | Yellow |
| Advanced | Red |

---

## 🧭 Navigation Patterns

### Breadcrumb

Consistent hierarchy display:
```
Courses > [Course Title] > [Lesson Title]
```

Implementation uses Flexbox with SVG chevron icons between items.

### Lesson Sidebar

On lesson player page:
- Course title header
- Ordered lesson list
- Current lesson highlighting
- Preview badge on first lesson
- Lock icons for restricted content

---

## 🌗 Dark Mode

Full dark mode support via Tailwind classes:

```blade
class="bg-white dark:bg-zinc-800
       border-zinc-200 dark:border-zinc-700
       text-zinc-900 dark:text-zinc-100"
```

Flux UI components automatically adapt to dark mode preference.

---

## 📱 Responsive Design

### Breakpoints

| Breakpoint | Width | Grid Columns |
|------------|-------|--------------|
| Mobile | < 640px | 1 |
| Tablet | 640px - 1024px | 2 |
| Desktop | > 1024px | 3 |

### Course Index Grid

```blade
<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach ($this->data as $course)
        <!-- course card -->
    @endforeach
</div>
```

### Lesson Player Layout

```
Mobile/Tablet:          Desktop:
┌─────────────────┐     ┌──────────┬──────────────┐
│ Breadcrumb      │     │ Breadcrumb            │
├─────────────────┤     ├──────────┴──────────────┤
│ Video Player    │     │ Video Player │ Lessons  │
├─────────────────┤     │              │ List     │
│ Lesson Info     │     │              │          │
├─────────────────┤     │              │          │
│ Lessons List    │     │              │          │
└─────────────────┘     └──────────────┴─────────┘
```

---

## 🎯 Alpine.js Behaviors

### Toast Notifications

Flash messages appear temporarily after actions:

```blade
<div x-data="{ show: true }"
     x-init="setTimeout(() => show = false, 3000)"
     x-show="show"
     class="...">
    {{ session('message') }}
</div>
```

### Action Confirmation

Used in destructive actions (unenroll, delete account):
- Modal dialog for confirmation
- Require password re-entry for sensitive actions
- Cancel/Confirm button pair

---

## 🖼️ Assets

### Images

| Asset | Location | Usage |
|-------|----------|-------|
| Video placeholder | `public/images/video-placeholder.jpg` | Plyr poster image |
| Favicon | `public/favicon.svg` | Browser tab icon |
| Apple touch | `public/apple-touch-icon.png` | iOS home screen |

### CSS

TailwindCSS compiled via Vite:
- Source: `resources/css/app.css`
- Output: `public/build/assets/app-*.css`

### JavaScript

Bundled via Vite:
- App entry: `resources/js/app.js`
- Plyr initialization for video players
- Flux UI components auto-registered
