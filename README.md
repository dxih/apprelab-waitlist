# AppRelab - Waitlist Landing Page

A modern, responsive coming soon landing page with waitlist functionality for AppRelab. This project features a sleek dark theme with blue and orange accents, database storage, and email notifications.

![AppRelab Preview](https://images.unsplash.com/photo-1581276879432-15e50529f34b?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80)

## ✨ Features

- **Modern Design**: Dark theme with blue and orange color scheme
- **Responsive Layout**: Works perfectly on desktop, tablet, and mobile devices
- **Waitlist Form**: User registration with validation
- **Database Storage**: SQLite database for storing waitlist entries
- **Email Notifications**: Automatic emails to users and admins using PHPMailer
- **Countdown Timer**: Dynamic launch countdown
- **Animated Elements**: Particle background and hover effects
- **Modern Alerts**: Sleek notification system for user feedback

## 🚀 Quick Start

### Prerequisites

- PHP 7.4 or higher
- SQLite extension for PHP
- Composer (for PHPMailer)
- Web server (Apache, Nginx, etc.)

### Installation

1. **Clone or download the project files**
   ```bash
   git clone https://github.com/dxih/apprelab-waitlist
   cd apprelab-waitlist
   ```

2. **Install dependencies**
   ```bash
   composer require phpmailer/phpmailer
   ```

3. **Set up file permissions**
   ```bash
   chmod 755 .
   chmod 644 index.html waitlist.php
   chmod 666 waitlist.db # If the file exists already
   ```

4. **Configure Mailtrap (for email testing)**
   - Update the SMTP settings in `waitlist.php` with your Mailtrap credentials:
   ```php
   $mail->Host = 'sandbox.smtp.mailtrap.io';
   $mail->Username = 'your-mailtrap-username';
   $mail->Password = 'your-mailtrap-password';
   $mail->Port = 2525;
   ```

5. **Upload to your server** or run locally with a PHP server:
   ```bash
   php -S localhost:8000
   ```

6. **Visit the site** in your browser at `http://localhost:8000`

## ⚙️ Configuration

### Email Settings

Edit the following in `waitlist.php`:

```php
// Mailtrap configuration (for testing)
$mail->Host = 'sandbox.smtp.mailtrap.io';
$mail->Username = 'your-mailtrap-username';
$mail->Password = 'your-mailtrap-password';
$mail->Port = 2525;

// Production email configuration (when ready)
// $mail->Host = 'smtp.gmail.com';
// $mail->Username = 'your-email@gmail.com';
// $mail->Password = 'your-app-password';
// $mail->Port = 587;
```

### Database Configuration

The SQLite database is automatically created when the first form is submitted. The database file (`waitlist.db`) will be created in the same directory as the PHP script.

### Customization

- **Colors**: Modify the color scheme in the Tailwind config within the HTML file
- **Content**: Update text content directly in the HTML
- **Images**: Replace the Unsplash image URL with your own image
- **Countdown**: Adjust the countdown timer in the JavaScript section

## 📧 Email Templates

The system sends two types of emails:

1. **User Welcome Email**: Sent to users who join the waitlist
2. **Admin Notification Email**: Sent to the admin when someone joins

Both emails use HTML templates with inline CSS for compatibility.

## 🗃️ Database Schema

The SQLite database uses a simple table structure:

```sql
CREATE TABLE waitlist (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

## 🔧 Troubleshooting

### Common Issues

1. **Emails not sending**
   - Check Mailtrap credentials
   - Verify PHP mail() function is configured
   - Check server firewall allows SMTP traffic

2. **Database errors**
   - Ensure directory is writable by web server
   - Check SQLite extension is enabled in PHP

3. **Form submissions failing**
   - Check JavaScript console for errors
   - Verify PHP is properly configured

### Debug Mode

Enable debug mode by uncommenting these lines in `waitlist.php`:

```php
// Enable verbose debug output
$mail->SMTPDebug = 2;
```

## 📱 Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## 🛡️ Security Considerations

- Input validation on both client and server side
- SQL injection prevention with prepared statements
- XSS protection through output encoding
- CSRF protection recommended for production use

## 📈 Analytics Integration (Optional)

To add Google Analytics, insert this code before the closing `</head>` tag:

```html
<!-- Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=GA_MEASUREMENT_ID"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'GA_MEASUREMENT_ID');
</script>
```

## 🌐 Live Demo

A live demo can be viewed at [your-domain.com](https://your-domain.com)

## 📄 License

This project is licensed under the MIT License - see the LICENSE file for details.

## 🤝 Contributing

1. Fork the project
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📞 Support

If you have any questions or issues, please contact:
- Email: support@apprelab.com
- Twitter: [@AppRelab](https://twitter.com/AppRelab)

## 🚀 Deployment

### For Production

1. Update email settings to use a production SMTP server
2. Enable SSL/TLS for secure connections
3. Set up proper DNS records (SPF, DKIM, DMARC)
4. Implement additional security headers
5. Set up monitoring and logging

### Deployment Platforms

- **Shared Hosting**: Upload files via FTP/cPanel
- **VPS**: Use Git, SFTP, or deployment scripts
- **Platform as a Service**: Configure for Heroku, DigitalOcean App Platform, etc.

---

**AppRelab** - Revolutionizing app development. Join the waitlist today!