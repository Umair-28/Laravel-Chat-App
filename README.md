# Laravel Chat App

A real-time chat application built with Laravel, Vue.js, and Pusher.

## Overview

This chat application allows users to send and receive messages in real-time. It utilizes Laravel Echo and Pusher for WebSocket communication.

## Features

- Real-time message updates
- Simple and clean user interface
- Vue.js for frontend interactivity
- Laravel Echo and Pusher for real-time communication

## Prerequisites

- PHP (>= 7.4)
- Composer
- Node.js
- NPM or Yarn
- Laravel Echo
- Pusher account and API key

## Setup

1. Clone the repository:

   ```bash
   git clone <repository-url>

Commands to RUN the Project

composer install
npm install
cp .env.example .env
php artisan migrate
php artisan key:generate
php artisan serve
npm run dev
