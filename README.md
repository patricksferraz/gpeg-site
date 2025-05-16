<div align="center">
  <h1>
    <img src="public/img/favicon.svg" alt="GPEG Logo" width="25" style="vertical-align: bottom; margin-bottom: 2px"/>
    GPEG - School Management Research Group
  </h1>
</div>

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![PHP Version](https://img.shields.io/badge/PHP-7.1.3-blue.svg)](https://www.php.net/)
[![Laravel Version](https://img.shields.io/badge/Laravel-5.7-red.svg)](https://laravel.com/)

## Description

GPEG (Grupo de Pesquisa em Educação e Gestão) is a multidisciplinary research group based at the Universidade Estadual de Santa Cruz (UESC). Our mission is to investigate and address key questions related to School Management, Teacher Training, and Educational History. Currently, we are focused on the research project: **"School Management and IDEB Results: What is the Relationship?"** This project aims to identify the main factors influencing the performance of public high schools in Bahia, Brazil, based on the IDEB (Basic Education Development Index).

## Table of Contents

- [Description](#description)
- [Table of Contents](#table-of-contents)
- [Features](#features)
- [Getting Started](#getting-started)
  - [Prerequisites](#prerequisites)
  - [Installation](#installation)
- [Usage](#usage)
- [Project Structure](#project-structure)
- [Contributing](#contributing)
- [Team](#team)
- [License](#license)
- [Acknowledgements](#acknowledgements)
- [Contact](#contact)

## Features

- **Multilingual Support**: Available in English and Portuguese.
- **Research Forms**: Interactive forms for data collection from school managers.
- **Team Presentation**: Showcase of our multidisciplinary team of researchers.
- **Contact Form**: Easy communication with the research group.
- **Modern Tech Stack**: Built with Laravel 5.7, Vue.js, and Bootstrap.


## Getting Started

### Prerequisites

- PHP >= 7.1.3
- Composer
- Node.js and NPM
- Laravel 5.7

### Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/patricksferraz/gpeg-site.git
   cd gpeg-site
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Install JavaScript dependencies:
   ```bash
   npm install
   ```

4. Set up your environment:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. Run database migrations:
   ```bash
   php artisan migrate
   ```

6. Build assets:
   ```bash
   npm run dev
   ```

7. Start the development server:
   ```bash
   php artisan serve
   ```

## Usage

- **Home Page**: Learn about GPEG and our research projects.
- **Research Forms**: Access and fill out research questionnaires.
- **Team**: Meet our team of researchers.
- **Contact**: Reach out to us via the contact form.

## Project Structure

- `app/`: Core application code
- `resources/`: Views, language files, and assets
- `routes/`: Application routes
- `public/`: Publicly accessible files
- `tests/`: Automated tests

## Contributing

We welcome contributions! Please read our [Contributing Guidelines](CONTRIBUTING.md) for details on our code of conduct and the process for submitting pull requests.

## Team

- **Profa. Dra. Sônia Fonseca** - Coordinator
- **Prof. Dr. Alfredo Dib** - Coordinator
- **Profa. Dra. Sandra Magina** - Researcher
- **Profa. Dra. Cristiane Nunes** - Researcher
- **Profa. Dra. Maria Elizabete Couto** - Researcher
- **Profa. Ms. Adriana Lemos** - Researcher
- **Profa. Ms. Núbia Coelho** - Researcher
- **Profa. Ms. Rejane Cristo** - Researcher
- **Profa. Lizandra Lima** - Researcher
- **Profa. Délia Ladeia** - Researcher
- **João Vitor Mendes** - Researcher
- **Eva Maia Malta** - Researcher
- **Patrick Silva Ferraz** - Researcher ([GitHub](https://github.com/patricksferraz))

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Acknowledgements

- Universidade Estadual de Santa Cruz (UESC)
- CNPq
- All contributors and partners

## Contact

For any inquiries, please contact us at: [gpeg.uesc@gmail.com](mailto:gpeg.uesc@gmail.com)
