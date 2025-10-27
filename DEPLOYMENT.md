# DEPLOYMENT GUIDE - Insurance Application

## 🚀 How to Deploy Your Laravel App

You have **3 easy deployment options**. Choose one:

---

## ✅ **Option 1: Railway (EASIEST - FREE)**

### Step-by-Step:

1. **Create a Railway Account**
   - Go to https://railway.app
   - Sign up with GitHub (free account)

2. **Create New Project**
   - Click "New Project"
   - Select "Deploy from GitHub repo"
   - Connect your GitHub account and select this repository

3. **Add SQLite Database**
   - Railway will auto-detect your Laravel app
   - No database setup needed (using SQLite)

4. **Set Environment Variables**
   - In Railway dashboard, go to Variables tab
   - Add these variables:
     ```
     APP_NAME=Insurance Application
     APP_ENV=production
     APP_DEBUG=false
     APP_KEY=base64:VQ/gau6vH07vYPogqRcyRknP7keXrEK0WypO8dqt/l4=
     DB_CONNECTION=sqlite
     SESSION_DRIVER=database
     CACHE_DRIVER=file
     QUEUE_CONNECTION=sync
     LOG_CHANNEL=stack
     LOG_LEVEL=error
     ```

5. **Deploy!**
   - Click "Deploy"
   - Railway will automatically build and deploy
   - You'll get a URL like: `https://your-app.railway.app`

6. **Generate Domain**
   - Go to Settings → Generate Domain
   - Your app will be live!

---

## ✅ **Option 2: Render (EASY - FREE)**

### Step-by-Step:

1. **Create Render Account**
   - Go to https://render.com
   - Sign up with GitHub

2. **Create New Web Service**
   - Click "New +"  → "Web Service"
   - Connect your repository

3. **Configure Service**
   - Name: `insurance-app`
   - Environment: `PHP`
   - Build Command: `composer install --no-dev --optimize-autoloader`
   - Start Command: `bash start.sh`
   - Free tier is OK

4. **Add Environment Variables**
   ```
   APP_NAME=Insurance Application
   APP_ENV=production
   APP_DEBUG=false
   APP_KEY=base64:VQ/gau6vH07vYPogqRcyRknP7keXrEK0WypO8dqt/l4=
   DB_CONNECTION=sqlite
   SESSION_DRIVER=database
   CACHE_DRIVER=file
   ```

5. **Create Deploy**
   - Click "Create Web Service"
   - Wait 5-10 minutes for deployment

---

## ✅ **Option 3: Heroku (MEDIUM - FREE TIER LIMITED)**

### Step-by-Step:

1. **Install Heroku CLI**
   ```powershell
   winget install Heroku.HerokuCLI
   ```

2. **Login to Heroku**
   ```powershell
   heroku login
   ```

3. **Create Heroku App**
   ```powershell
   heroku create your-insurance-app
   ```

4. **Add Buildpack**
   ```powershell
   heroku buildpacks:set heroku/php
   ```

5. **Set Environment Variables**
   ```powershell
   heroku config:set APP_NAME="Insurance Application"
   heroku config:set APP_ENV=production
   heroku config:set APP_DEBUG=false
   heroku config:set APP_KEY=base64:VQ/gau6vH07vYPogqRcyRknP7keXrEK0WypO8dqt/l4=
   heroku config:set DB_CONNECTION=sqlite
   heroku config:set SESSION_DRIVER=database
   ```

6. **Deploy**
   ```powershell
   git add .
   git commit -m "Deploy to Heroku"
   git push heroku main
   ```

---

## 🔧 **Before You Deploy - Checklist**

✅ Make sure you have committed all files to Git:
```powershell
git add .
git commit -m "Ready for deployment"
git push origin main
```

✅ Your `.gitignore` should include:
```
/node_modules
/public/hot
/public/storage
/storage/*.key
/vendor
.env
.env.backup
.phpunit.result.cache
```

✅ Make sure `database/database.sqlite` exists:
```powershell
New-Item -ItemType File -Path "database/database.sqlite" -Force
```

---

## 🎯 **Recommended: Railway**

**Railway is the easiest!** It auto-detects Laravel, handles everything, and gives you a free tier.

### Quick Railway Deploy:
1. Push your code to GitHub
2. Go to railway.app
3. Click "New Project" → "Deploy from GitHub"
4. Select your repo
5. Add environment variables
6. Done! ✨

---

## 🆘 **Troubleshooting**

### Error: "No APP_KEY"
Generate a new key:
```powershell
php artisan key:generate --show
```
Copy the output and add it to your environment variables.

### Error: "Database not found"
Make sure `DB_CONNECTION=sqlite` is set in environment variables.

### Error: "Permission denied"
The deployment platform will handle permissions automatically.

---

## 📞 **Need More Help?**

If you're stuck, tell me:
1. Which platform are you trying (Railway/Render/Heroku)?
2. What error message are you seeing?
3. Where in the process are you stuck?

I'll guide you through it! 🚀
