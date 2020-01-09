"""
Django settings for project project.
For the full list of settings and their values, see
"""

import os
import datetime

# Build paths inside the project like this: os.path.join(BASE_DIR, ...)
BASE_DIR = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))


# Quick-start development settings - unsuitable for production
# See https://docs.djangoproject.com/en/2.2/howto/deployment/checklist/

# SECURITY WARNING: keep the secret key used in production secret!
SECRET_KEY = 's!v^tuo9ratmac*4k54=f4uk$yhu^!w%g$&^it*)ef4&i7@j!)'

# SECURITY WARNING: don't run with debug turned on in production!
DEBUG = True

ALLOWED_HOSTS = ["*"]
# AUTH_USER_MODEL = 'useraccount.User'

# Application definition

INSTALLED_APPS = [
    'channels',
    'django.contrib.admin',
    'django.contrib.auth',
    'django.contrib.contenttypes',
    'django.contrib.sessions',
    'django.contrib.messages',
    'django.contrib.staticfiles',
    'django.contrib.sites',
    'crispy_forms',
    'bootstrap3',
    'webpack_loader',
    'imagekit',
    'django_celery_results',
    'django_celery_beat',
    'django_cleanup.apps.CleanupConfig',
    'corsheaders',
    'django_filters',

    'allauth',
    'allauth.account',
    'allauth.socialaccount',
    # 'allauth.socialaccount.providers.baidu',
    # 'allauth.socialaccount.providers.google',
    # 'allauth.socialaccount.providers.facebook',
    # 'allauth.socialaccount.providers.line',

    'django_extensions',
    'widget_tweaks', #能控制css的类名，这时我推荐使用django-widget-teaks。


    'rest_framework_swagger',
    'rest_framework',
    'rest_framework.authtoken',
    

    #my own apps
    'musics',
    'useraccount',
    'chat',
    "lottery_shop",
    "shoppingcart",
    'mail_exchange',
    "ds_exchange",
    'exrate',
    'rentalhouse',
]

MIDDLEWARE = [
    'django.middleware.security.SecurityMiddleware',
    'django.contrib.sessions.middleware.SessionMiddleware',
    'django.middleware.common.CommonMiddleware',
    'django.middleware.csrf.CsrfViewMiddleware',
    'django.contrib.auth.middleware.AuthenticationMiddleware',
    'django.contrib.messages.middleware.MessageMiddleware',
    'django.middleware.clickjacking.XFrameOptionsMiddleware',
    'corsheaders.middleware.CorsMiddleware',
]

# CORS_ALLOW_CREDENTIALS = True
# CORS_ORIGIN_ALLOW_ALL = True

# CORS_ORIGIN_WHITELIST = [
#     "https://example.com",
#     "https://sub.example.com",
#     "http://localhost:8080",
#     "http://localhost:8000",
#     "http://127.0.0.1:8000"
# ]

ROOT_URLCONF = 'project.urls'

TEMPLATES = [
    {
        'BACKEND': 'django.template.backends.django.DjangoTemplates',
        'DIRS': [os.path.join(BASE_DIR, 'templates'), os.path.join(BASE_DIR, 'templates', 'allauth')],
        'APP_DIRS': True,
        'OPTIONS': {
            'context_processors': [
                'django.template.context_processors.debug',
                'django.template.context_processors.request',
                'django.contrib.auth.context_processors.auth',
                'django.contrib.messages.context_processors.messages',


                # `allauth` needs this from django
                'django.template.context_processors.request',
            ],
        },
    },
]

WSGI_APPLICATION = 'project.wsgi.application'
# channel settings
ASGI_APPLICATION = "project.routing.application"
CHANNEL_LAYERS = {
    'default': {
        'BACKEND': 'channels_redis.core.RedisChannelLayer',
        'CONFIG': {
            'hosts': [('redis', 6379)],
        },
    }
}

AUTHENTICATION_BACKENDS = (
    'useraccount.viewsets.CustomBackend',
    'django.contrib.auth.backends.ModelBackend',
    'allauth.account.auth_backends.AuthenticationBackend',
)
SITE_ID = 1


# Database
# https://docs.djangoproject.com/en/2.2/ref/settings/#databases

DATABASES = {
    'default': {
        'ENGINE': 'django.db.backends.postgresql_psycopg2',
        'NAME': 'postgres',
        'USER': 'postgres',
        'PASSWORD': 'password123',
        'HOST': 'postgres',
        'PORT': 5432,
    }
}


CACHES = {
    "default": {
        "BACKEND": "django_redis.cache.RedisCache",
        "LOCATION": "redis://redis:6379/0",
        "OPTIONS": {
            "CLIENT_CLASS": "django_redis.client.DefaultClient",
            "SERIALIZER": "django_redis.serializers.json.JSONSerializer",
        }
    }
}

SESSION_ENGINE = "django.contrib.sessions.backends.cache"
SESSION_CACHE_ALIAS = "default"

# Password validation
# https://docs.djangoproject.com/en/2.2/ref/settings/#auth-password-validators

AUTH_PASSWORD_VALIDATORS = [
    {
        'NAME': 'django.contrib.auth.password_validation.UserAttributeSimilarityValidator',
    },
    {
        'NAME': 'django.contrib.auth.password_validation.MinimumLengthValidator',
    },
    {
        'NAME': 'django.contrib.auth.password_validation.CommonPasswordValidator',
    },
    {
        'NAME': 'django.contrib.auth.password_validation.NumericPasswordValidator',
    },
]
REST_FRAMEWORK = {
    'DEFAULT_FILTER_BACKENDS': (
        'django_filters.rest_framework.DjangoFilterBackend',
    ),
    'DEFAULT_PERMISSION_CLASSES': (
        # 'rest_framework.permissions.IsAuthenticated',
         # 確認のために認証方法を変更する
        # 'rest_framework.permissions.DjangoModelPermissionsOrAnonReadOnly',
    ),  
    'DEFAULT_AUTHENTICATION_CLASSES': (
        'rest_framework_jwt.authentication.JSONWebTokenAuthentication',
        'rest_framework.authentication.SessionAuthentication',
        'rest_framework.authentication.BasicAuthentication',
    ),
    'DEFAULT_VERSIONING_CLASS': 'rest_framework.versioning.AcceptHeaderVersioning',
    'NON_FIELD_ERRORS_KEY': 'detail',
    'TEST_REQUEST_DEFAULT_FORMAT': 'json'
}
JWT_AUTH = {
    # 'JWT_ENCODE_HANDLER':
    # 'rest_framework_jwt.utils.jwt_encode_handler',

    # 'JWT_DECODE_HANDLER':
    # 'rest_framework_jwt.utils.jwt_decode_handler',

    # 'JWT_PAYLOAD_HANDLER':
    # 'rest_framework_jwt.utils.jwt_payload_handler',

    # 'JWT_PAYLOAD_GET_USER_ID_HANDLER':
    # 'rest_framework_jwt.utils.jwt_get_user_id_from_payload_handler',

    # 'JWT_RESPONSE_PAYLOAD_HANDLER':
    # 'rest_framework_jwt.utils.jwt_response_payload_handler',

    # 'JWT_SECRET_KEY': settings.SECRET_KEY,
    # 'JWT_GET_USER_SECRET_KEY': None,
    # 'JWT_PUBLIC_KEY': None,
    # 'JWT_PRIVATE_KEY': None,
    # 'JWT_ALGORITHM': 'HS256',
    # 'JWT_VERIFY': True,
    # 'JWT_VERIFY_EXPIRATION': True,
    # 'JWT_LEEWAY': 0,
    # 'JWT_AUDIENCE': None,
    # 'JWT_ISSUER': None,

    'JWT_ALLOW_REFRESH': True,
    'JWT_REFRESH_EXPIRATION_DELTA': datetime.timedelta(days=7),
    'JWT_EXPIRATION_DELTA': datetime.timedelta(days=7),
    'JWT_AUTH_HEADER_PREFIX': 'JWT',
    # 'JWT_AUTH_COOKIE': None,

}


# Internationalization
# https://docs.djangoproject.com/en/2.2/topics/i18n/
LANGUAGE_CODE = 'ja'
LOCALE_PATHS = (
    os.path.join(BASE_DIR, 'locale'),
)
LANGUAGES = (
    ('ja', u'日本語'),
    ('zh', u'中文简体'),
)


TIME_ZONE = 'Asia/Tokyo'

USE_I18N = True

USE_L10N = True

USE_TZ = False


# Static files (CSS, JavaScript, Images)
# https://docs.djangoproject.com/en/2.2/howto/static-files/

STATIC_URL = '/static/'
STATIC_ROOT = os.path.join(BASE_DIR, 'static')
# STATICFILES_DIRS = [
#     os.path.join(BASE_DIR, 'static')
# ]
MEDIA_ROOT = os.path.join(BASE_DIR, 'media')
MEDIA_URL = '/media/'


CRISPY_TEMPLATE_PACK = 'bootstrap4'
LOGIN_REDIRECT_URL = '/'
# ACCOUNT_AUTHENTICATION_METHOD = 'username_email'
# ACCOUNT_EMAIL_REQUIRED = True
ACCOUNT_LOGOUT_REDIRECT_URL ="/"

ACCOUNT_FORMS = {
'signup': 'useraccount.forms.SignupForm'
}

# mail
# for email debug settings
# EMAIL_BACKEND = 'django.core.mail.backends.console.EmailBackend'
EMAIL_BACKEND = 'django.core.mail.backends.smtp.EmailBackend'


# Gmail setting
# EMAIL_HOST = 'smtp.gmail.com'
# EMAIL_PORT = 587
# EMAIL_HOST_USER = 'lionhu2009@gmail.com'
# EMAIL_HOST_PASSWORD = 'Hisshghu3577'
# EMAIL_USE_TLS = True


# QQ Mail settings
EMAIL_HOST = 'smtp.qq.com'
EMAIL_PORT = 587
EMAIL_HOST_USER = '1153507355@qq.com'
EMAIL_HOST_PASSWORD = 'ulwhtjtptxhmiddc'
EMAIL_USE_TLS = True
EMAIL_USE_SSL = False
EMAIL_SSL_CERTFILE = None
EMAIL_SSL_KEYFILE = None
EMAIL_TIMEOUT = None
DEFAULT_FROM_EMAIL = '1153507355@qq.com'





BROKER_TRANSPORT_OPTIONS = {
    'visibility_timeout': 3600
}
# CELERY_ACCEPT_CONTENT = ['application/json']
# CELERY_TASK_SERIALIZER = ['json']
CELERY_RESULT_SERIALIZER = 'json'
CELERY_RESULT_BACKEND = 'django-db'
CELERY_CACHE_BACKEND = 'django-cache'


CELERY_TIMEZONE = TIME_ZONE
DJANGO_CELERY_BEAT_TZ_AWARE = False
CELERY_BEAT_SCHEDULER = 'django_celery_beat.schedulers:DatabaseScheduler'


WEBPACK_LOADER = {
    'DEFAULT': {
        'CACHE': not DEBUG,
        'BUNDLE_DIR_NAME': 'bundles/', # must end with slash
        'STATS_FILE': os.path.join(BASE_DIR, 'vue_project/webpack-stats.json'),
        # 'POLL_INTERVAL': 0.1,
        # 'TIMEOUT': None,
        # 'IGNORE': ['.+\.hot-update.js', '.+\.map']
    }
}
# importing logger settings
try:
    from .logger_settings import *
except Exception as e:
    # in case of any error, pass silently.
    pass
    
# Project-specific settings
ADMIN_ROOT_ID=1
ADMIN_ROOT_EMAIL="huhaiguang@me.com"
HOSTNAME="https://www.exrate.world"
DATETIME_FORMAT = '%Y-%m-%d %H:%M'
ORDER_BONUS_PARENT=25
ORDER_BONUS_GRANTPARENT=25
ORDER_BONUS_DISTRIBUTOR=25

OFFER_MARGIN_JPY=100
OFFER_MARGIN_RMB=10
ORDER_MARGINRATE_JPY=0.15
ORDER_MARGINRATE_RMB=0.1

AUCTION_ORDER_BONUS_JPY=10
DS_ORDER_BONUS_JPY=20

AUTO_TODAYRATE=True
JPY_RATE = {
    "name":"jpy",
    "time":"",
    "day":"",
    "code":"JPY",
    "hui_in":6.3785,
    "hui_out":6.4310,
    "chao_in":6.2010,
    "chao_out":6.4310
  }




# Shop related
MAX_RENTAL_NUM=3
IN_RENTAL_MODE = ["booking","booked","toCustomer","fromCustomer","inTrouble"]



