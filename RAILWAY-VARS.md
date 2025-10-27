# Railway Environment Variables - Complete List

Add these to your Railway project under the "Variables" tab:

## Required Variables (Add these if missing):

```
APP_NAME=Insurance Application
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:VQ/gau6vH07vYPogqRcyRknP7keXrEK0WypO8dqt/l4=
APP_URL=https://web-production-7d08.up.railway.app

DB_CONNECTION=sqlite

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_SECURE_COOKIE=true

CACHE_DRIVER=file
LOG_LEVEL=error

ASSET_URL=https://web-production-7d08.up.railway.app
```

## Important for HTTPS:
- `APP_URL` should start with `https://` (your Railway domain)
- `SESSION_SECURE_COOKIE=true` ensures cookies only work over HTTPS
- `ASSET_URL` ensures assets load over HTTPS

## How to Update:

1. Go to Railway Dashboard
2. Click on your project
3. Click "Variables" tab
4. Add or update these variables
5. Railway will automatically redeploy

The security warning will disappear once these are set correctly!
