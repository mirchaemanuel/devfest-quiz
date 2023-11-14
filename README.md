[![tests](https://github.com/mirchaemanuel/devfest-quiz/actions/workflows/app.yml/badge.svg?branch=master)](https://github.com/mirchaemanuel/devfest-quiz/actions/workflows/app.yml)[![Build Base PHP Image](https://github.com/mirchaemanuel/devfest-quiz/actions/workflows/build-base-php-image.yaml/badge.svg)](https://github.com/mirchaemanuel/devfest-quiz/actions/workflows/build-base-php-image.yaml)

# DevFest Quiz App - "The Journey of a Commit"

__IT IS JUST A DEMO PROJECT FOR THE SPEECH__

__IT IS STILL UNDER ACTIVE DEVELOPMENT__

## About the Project

This Laravel application, crafted for the Google DevFest Pescara 2023, serves as a practical demonstration for the talk
titled "The Journey of a Commit", which will be presented by Mircha Emanuel D'Angelo, a senior full-stack developer, and
Aurelio Forese, a cloud engineer for Netsons Srl. The project is designed to showcase the entire lifecycle of a commit -
from inception to production deployment. This includes the development and deployment cycle, emphasizing DevOps
principles and practices.

Further details about the talk can be found here: [DevFest Pescara Agenda](https://devfest.gdgpescara.it/agenda).

## Features

- **User Authentication**: Implemented using Laravel Jetstream, this feature ensures a secure login and registration
  process for users.
- **Interactive Quiz**: A real-time, dynamic quiz component developed with Livewire to engage participants.
- **Leaderboard**: Tracks and displays user rankings, adding a competitive edge to the quiz.
- **Badges System**: Participants can earn badges for their achievements, such as the "First Place" badge for topping
  the leaderboard.

## Technical Stack

- **Backend Framework**: Laravel
- **User Authentication**: Laravel Jetstream
- **Frontend Interaction**: Livewire
- **Testing**: Test-Driven Development (TDD) Approach (with Pest)

In the talk we shall also discuss the following:
- **Version Control and Workflow**: GitFlow
- **Continuous Integration/Continuous Deployment (CI/CD)**: Implemented using a pipeline approach
- **Containerization and Orchestration**: Docker, Kubernetes, and ArgoCD

## Setup and Installation

### Prerequisites

- PHP 8.2
- Composer
- Node.js or Bun

### Installation

1. Clone the repo
   ```sh
   git clone https://github.com/mirchaemanuel/devfest-quiz.git
   ```
2. Install Composer packages
   ```sh
    composer install
    ```
3. Install NPM packages
   ```sh
   npm install
   #or
   bun install
   ```
4. Create a copy of the `.env.example` file and rename it to `.env`
5. Generate an application key
   ```sh
   php artisan key:generate
   ```
6. Migration and seeding
   ```sh
   php artisan migrate --seed
   ```

## Contributing

As this application is a demo for the DevFest Pescara talk, contributions are welcome to enhance its educational value.
Please feel free to submit pull requests or open issues for discussion.

## License

Distributed under the MIT License. See `LICENSE` for more information.

## Acknowledgements

A special thanks to the organizers of Google DevFest Pescara for the opportunity to showcase this project and share
insights on modern software development practices.
