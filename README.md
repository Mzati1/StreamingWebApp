
# 🎥 Movie Streaming Web Application

Welcome to the **Movie Streaming Web Application**! This Laravel-based project allows users to stream their favorite movies and series, discover information about actors, and manage their personal accounts. The app leverages the power of **The Movie Database (TMDb)** API for movie data and the **Vidsrc** API for seamless streaming. Built with **Laravel**, **TailwindCSS**, **DaisyUI**, **Livewire**, **Vite**, **Bootstrap**, **Laravel Mix**, and **Vue**, this application is both robust and user-friendly.

---

## 📖 Table of Contents

1. [Features](#features)
2. [In Progress Features](#in-progress-features)
3. [Tech Stack](#tech-stack)
4. [Getting Started](#getting-started)
   - [Prerequisites](#prerequisites)
   - [Setup Instructions](#setup-instructions)
5. [Contributing](#contributing)
6. [API Acknowledgments](#api-acknowledgments)
7. [License & Copyright](#license--copyright)

---

## ✨ Features

- **User-friendly account management**: Sign up, log in, and manage your profile effortlessly! 👤
- **Stream movies and series**: Dive into a vast library of content at your fingertips! 🎬
- **Detailed information**: Get insights about movies, series, and actors—everything you need to know! 🎥
- **Responsive design**: Enjoy a beautiful layout across all devices, powered by TailwindCSS and DaisyUI! 📱
- **Dynamic components**: Livewire brings your UI to life with real-time updates! ⚡

### 🚧 In Progress Features

- **Favorites & Lists**: Keep track of your beloved movies and series! 📌
- **Watch History**: Never forget what you've watched! 📅
- **Customizable Profile Pictures**: Personalize your account with unique profile pics! 🖼️
- **Performance Optimization**: Working towards seamless streaming! ⚡
- **Potential Front-end Revamp**: Considering a future shift to React.js! (TBD)

---

## 🛠️ Tech Stack

- **Backend**: Laravel 9
- **Frontend**: 
  - **TailwindCSS** & **Bootstrap** for styling 🎨
  - **DaisyUI** for beautiful components 🌟
  - **Vue** for reactive components 🔄
  - **Livewire** for dynamic interaction ⚡
- **Asset Management**: 
  - **Laravel Mix** for Webpack integration 📦
  - **Vite** for modern frontend tooling 🚀
- **Streaming API**: Vidsrc
- **Movie Data Source**: The Movie Database (TMDb)
- **Icons**: FontAwesome
- **Fonts**: Google Fonts

---

## 🚀 Getting Started

### Prerequisites

To run this project on your local machine, you’ll need:

- **MAMP/XAMPP** for your local web server setup
- **MySQL** for database management
- **Composer** for PHP dependency management
- **NPM** for managing frontend packages

### 🔧 Setup Instructions

Follow these steps to get the application running locally:

1. **Clone the repository**:
    ```bash
    git clone https://github.com/Mzati1/StreamingWebApp.git
    cd StreamingWebApp
    ```

2. **Install PHP dependencies**:
    ```bash
    composer install
    ```

3. **Install NPM dependencies**:
    ```bash
    npm install
    ```

4. **Set up your environment variables**:
    - Copy `.env.example` to `.env`:
      ```bash
      cp .env.example .env
      ```
    - Edit the `.env` file with your database credentials and API keys:
      ```bash
      DB_DATABASE=your_db_name
      DB_USERNAME=your_db_username
      DB_PASSWORD=your_db_password
      TMDB_API_KEY=your_tmdb_api_key
      VIDSTREAM_API_KEY=your_vidsrc_api_key
      ```

5. **Run database migrations**:
    ```bash
    php artisan migrate
    ```

6. **Run the development server**:
    ```bash
    php artisan serve
    ```

7. **For development builds of frontend assets**:
    ```bash
    npm run dev
    ```

8. **For production builds**:
    ```bash
    npm run build
    ```

---

## 🤝 Contributing

Contributions are welcome! If you'd like to help improve this project, here’s how you can get started:

1. **Fork the repository**: Click on the “Fork” button at the top right of this page to create your own copy of the project.
2. **Create a new branch**: Use a descriptive name for your branch.
   ```bash
   git checkout -b feature/YourFeatureName
   ```
3. **Make your changes**: Implement your improvements or new features.
4. **Commit your changes**:
   ```bash
   git commit -m "Add your message here"
   ```
5. **Push to your branch**:
   ```bash
   git push origin feature/YourFeatureName
   ```
6. **Create a Pull Request**: Go to the original repository, select your branch, and click “New Pull Request”.

Thank you for any contributions you make! Your efforts help improve the application for everyone. 🙌

---

## 🛡️ API Acknowledgments

This project integrates various external APIs and resources:

- [The Movie Database (TMDb) API](https://www.themoviedb.org/) 🎬 for comprehensive movie data
- [Vidsrc API](https://vidsrc.me/) 📡 for streaming capabilities
- [Google Fonts](https://fonts.google.com/) 🎨 for typography
- [FontAwesome](https://fontawesome.com/) ✨ for a range of icons

---

## 📝 License & Copyright

© 2024 Mzati. All rights reserved.

This project is intended for educational purposes only. All third-party APIs and data used in this application are the property of their respective owners. Please ensure proper attribution to the API providers in any usage of this application.

---

Enjoy streaming! If you encounter any issues or have suggestions, feel free to reach out!
