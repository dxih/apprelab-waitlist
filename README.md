Here’s a refactored version of your **AppRelab Waitlist Landing Page README** with the **two preview images (laptop and mobile)** included under the preview section:

---

# AppRelab - Waitlist Landing Page

A modern, responsive coming soon landing page with waitlist functionality for **AppRelab**.
This project features a sleek dark theme with blue and orange accents, database storage, and email notifications.

## 🖼️ Preview

**Laptop Preview**
![AppRelab Laptop Preview](assets/preview/laptop.png)

##

**Mobile Preview**
![AppRelab Mobile Preview](assets/preview/mobile.png)

---

## ✨ Features

* **Modern Design**: Dark theme with blue and orange color scheme
* **Responsive Layout**: Works perfectly on desktop, tablet, and mobile devices
* **Waitlist Form**: User registration with validation
* **Database Storage**: SQLite database for storing waitlist entries
* **Email Notifications**: Automatic emails to users and admins using PHPMailer
* **Countdown Timer**: Dynamic launch countdown
* **Animated Elements**: Particle background and hover effects
* **Modern Alerts**: Sleek notification system for user feedback

---

## 🚀 Quick Start

### Prerequisites

* PHP 7.4 or higher
* SQLite extension for PHP
* Composer (for PHPMailer)
* Web server (Apache, Nginx, etc.)

### Installation

```bash
# 1. Clone or download the project files
git clone https://github.com/dxih/apprelab-waitlist
cd apprelab-waitlist

# 2. Install dependencies
composer require phpmailer/phpmailer

# 3. Set up file permissions
chmod 755 .
chmod 644 index.html waitlist.php
chmod 666 waitlist.db # If the file exists already
```

4. **Configure Mailtrap (for email testing)**
   Update the SMTP settings in `waitlist.php` with your Mailtrap credentials:

   ```php
   $mail->Host = 'sandbox.smtp.mailtrap.io';
   $mail->Username = 'your-mailtrap-username';
   $mail->Password = 'your-mailtrap-password';
   $mail->Port = 2525;
   ```

5. **Run locally**

   ```bash
   php -S localhost:8000
   ```

6. **Visit in browser**: [http://localhost:8000](http://localhost:8000)

---

## ⚙️ Configuration

### Email Settings

Edit in `waitlist.php`:

```php
$mail->Host = 'sandbox.smtp.mailtrap.io';
$mail->Username = 'your-mailtrap-username';
$mail->Password = 'your-mailtrap-password';
$mail->Port = 2525;
```

For production:

```php
$mail->Host = 'smtp.gmail.com';
$mail->Username = 'your-email@gmail.com';
$mail->Password = 'your-app-password';
$mail->Port = 587;
```

### Database

* SQLite DB (`waitlist.db`) auto-created on first form submission.
* Table schema:

```sql
CREATE TABLE waitlist (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

### Customization

* **Colors** → Tailwind config
* **Content** → Edit HTML text
* **Images** → Replace Unsplash image URL
* **Countdown** → Update JS section

---

## 📧 Email Templates

1. **User Welcome Email**
2. **Admin Notification Email**

Both include inline CSS for compatibility.

---

## 🔧 Troubleshooting

* **Emails not sending** → Check Mailtrap credentials / SMTP config
* **Database errors** → Ensure writable directory + SQLite extension enabled
* **Form issues** → Check JS console + PHP config

Enable debug mode in `waitlist.php`:

```php
$mail->SMTPDebug = 2;
```

---

## 📱 Browser Support

* Chrome (latest)
* Firefox (latest)
* Safari (latest)
* Edge (latest)
* iOS Safari, Chrome Mobile

---

## 🛡️ Security

* Input validation (client + server)
* SQL injection prevention (prepared statements)
* XSS protection (output encoding)
* CSRF protection recommended

---

## 📈 Analytics (Optional)

Insert before `</head>`:

```html
<script async src="https://www.googletagmanager.com/gtag/js?id=GA_MEASUREMENT_ID"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'GA_MEASUREMENT_ID');
</script>
```

---

## 🚀 Deployment

**For Production**

1. Update email settings (production SMTP)
2. Enable SSL/TLS
3. Configure SPF, DKIM, DMARC
4. Add security headers
5. Enable monitoring/logging

**Platforms**

* Shared Hosting (FTP/cPanel)
* VPS (Git/SFTP)
* PaaS (Heroku, DigitalOcean, etc.)

---

## 📄 License

MIT License – see `LICENSE` file.

## 🤝 Contributing

1. Fork repo
2. Create branch (`feature/AmazingFeature`)
3. Commit (`git commit -m 'Add AmazingFeature'`)
4. Push (`git push origin feature/AmazingFeature`)
5. Open PR

---

## 📞 Support

* Email: [support@apprelab.com](mailto:support@apprelab.com)
* Twitter: [@AppRelab](https://twitter.com/AppRelab)

---

✨ **AppRelab** – Revolutionizing app development. Join the waitlist today!

---

Do you want me to also **add a side-by-side comparison preview section** (laptop on the left, mobile on the right) instead of stacked previews?
