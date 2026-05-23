# @DominikPrabucki/TimeManagementApi

## About application

TimeManagement is a full-stack task and productivity management application built with Laravel, Vue 3, TypeScript, and Flutter.

The application allows users to:

- manage tasks, categories, and tags,
- track task statuses and priorities,
- monitor dashboard statistics,
- receive local mobile reminders,
- work in offline read-only mode on mobile devices,
- synchronize data between web and mobile applications.

### Tech stack

#### Backend
- Laravel 12
- PostgreSQL
- Redis

#### Frontend
- Vue
- TypeScript
- Vite
- TailwindCSS

#### Mobile
- Flutter
- Dart
- Riverpod


---

# Local development

## Requirements

- Docker
- Docker Compose
- GNU Make
- Node.js (optional outside container)
- Android Studio / Flutter SDK (for mobile app)

---

## Installation

```bash
cp .env.example .env
make init
make dev
