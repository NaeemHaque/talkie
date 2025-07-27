# 🧠 Talkie – Multi-LLM AI Chatbot (Laravel)

**Talkie** is a Laravel-based AI chatbot platform designed to seamlessly integrate with multiple Large Language Model (LLM) providers including:

- 🔷 [OpenAI Chat API (GPT-4/3.5)](https://platform.openai.com/docs/)
- 🟡 [Google Gemini (Bard) API](https://ai.google.dev/)
- 🟣 [Anthropic Claude API](https://docs.anthropic.com/claude/docs)

Talkie provides a clean, extendable structure to interact with various LLM APIs using a unified interface for building human-like chatbots, assistants, or automation workflows.

---

## ✨ Features

- ✅ Unified chat interface for multiple LLM APIs
- 🔐 Secure API key storage via Laravel `.env`
- 🧩 Extensible LLM service provider architecture
- 🗃️ Chat history (optional DB persistence)
- 🧵 Support for conversation context and memory
- 📡 RESTful API endpoints for frontend integration
- 🔧 Easy to extend or swap in your own providers

---

## ⚙️ Tech Stack

- **Framework**: Laravel 12.x
- **Language**: PHP 8.2+
- **HTTP Client**: Laravel's built-in `Http` facade
- **LLMs**:  Gemini
- **Upcoming**: OpenAI, Claude (Anthropic)

---

## 🚀 Getting Started

### 1. Clone the Repo

```bash
git clone https://github.com/yourusername/talkie.git
cd talkie
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Set Up Environment Variables

Copy the `.env.example` file to `.env` and fill in your API keys and other necessary details.

```bash
cp .env.example .env
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Set Up Environment Variables
In your `.env file`, configure API keys:
```bash
OPENAI_API_KEY=sk-...
GEMINI_API_KEY=...
CLAUDE_API_KEY=...
```

### 6. Run Migrations (if using DB for chat history)

```bash
php artisan migrate
```

### 7. Start the Development Server

```bash
php artisan serve
npm run dev
```

---

