# Generated by Django 2.2.2 on 2019-10-25 21:45

from django.db import migrations, models
import uuid


class Migration(migrations.Migration):

    dependencies = [
        ('useraccount', '0009_auto_20191025_2144'),
    ]

    operations = [
        migrations.AlterField(
            model_name='userprofile',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('f73ec6f8-2a7d-47ad-bf85-86e02dd1d347'), null=True),
        ),
    ]
