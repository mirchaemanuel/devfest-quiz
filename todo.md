# TODO

## Guest can
- see home page (page) ✅
- see ranking result in home page (page) ✅

## Members can
- log in (page)
- see list of quizzes (page)
- see quiz details (page)
- take a quiz (page)
- see quiz result (page)

```mermaid
erDiagram
    SESSIONS ||--o{ USER_QUIZ_ATTEMPTS : "has"
    SESSIONS {
        string id PK
        string user_id FK
        string ip_address
        string user_agent
        text payload
        integer last_activity
    }

    QUIZZES ||--o{ USER_QUIZ_ATTEMPTS : "contains"
    QUIZZES ||--o{ QUESTIONS : "includes"
    QUIZZES {
        id int PK
        created_at datetime
        updated_at datetime
    }

    USER_QUIZ_ATTEMPTS {
        id int PK
        user_id int FK
        quiz_id int FK
        score int
        completed_at datetime
        created_at datetime
        updated_at datetime
    }

    QUESTIONS {
        id int PK
        quiz_id int FK
        created_at datetime
        updated_at datetime
    }
```
