# 🚀 QUICK DEPLOYMENT CHECKLIST

## ✅ Pre-Deployment Checklist

- [ ] Run setup script: `.\setup-deploy.ps1` (Windows) or `bash setup-deploy.sh` (Linux/Mac)
- [ ] Make sure `database/database.sqlite` exists
- [ ] Verify all migrations work: `php artisan migrate:fresh`
- [ ] Test the app locally: `php artisan serve`
- [ ] Commit all changes to Git
- [ ] Push to GitHub

---

## 🎯 EASIEST METHOD: Railway (Recommended)

### Time: ~5 minutes

1. **Sign up**: Go to https://railway.app
2. **New Project**: Click "Deploy from GitHub repo"
3. **Connect repo**: Authorize GitHub and select `insurance-application`
4. **Add variables**: Click "Variables" and add:
   ```
   APP_KEY=base64:VQ/gau6vH07vYPogqRcyRknP7keXrEK0WypO8dqt/l4=
   APP_ENV=production
   APP_DEBUG=false
   DB_CONNECTION=sqlite
   SESSION_DRIVER=database
   CACHE_DRIVER=file
   ```
5. **Deploy**: Click "Deploy" - Railway does the rest!
6. **Get URL**: Settings → Generate Domain

**DONE!** Your app is live! 🎉

---

## 📋 Alternative: Render

### Time: ~10 minutes

1. **Sign up**: https://render.com
2. **New Web Service**: Connect your GitHub repo
3. **Settings**:
   - Environment: `PHP`
   - Build: `composer install --no-dev --optimize-autoloader`
   - Start: `bash start.sh`
4. **Environment Variables**: Same as Railway above
5. **Create Service**: Wait 5-10 minutes

---

## 🆘 Common Issues

### "APP_KEY is missing"
Generate new key:
```powershell
php artisan key:generate --show
```
Copy the output (starts with `base64:`) and add to environment variables.

### "Database error"
Make sure environment variable is: `DB_CONNECTION=sqlite`

### "502 Bad Gateway"
Wait 2-3 minutes after deployment. The server is still starting.

### "Application error"
Check logs in platform dashboard. Usually a missing environment variable.

---

## 🎯 My Recommendation

**Use Railway!** It's the easiest and most reliable for Laravel apps. Here's why:

✅ Auto-detects Laravel  
✅ No complex setup  
✅ Free tier is generous  
✅ Simple dashboard  
✅ Easy rollbacks  

---

## 📞 Still Stuck?

Tell me:
1. Which platform? (Railway/Render/Heroku)
2. What error message?
3. Screenshot of the error?

I'll help you fix it! 💪
