# Generated by Django 2.2.2 on 2019-11-24 12:05

from django.db import migrations, models
import uuid


class Migration(migrations.Migration):

    dependencies = [
        ('useraccount', '0046_auto_20191122_1513'),
    ]

    operations = [
        migrations.AlterField(
            model_name='userprofile',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('3a6e6079-faa5-4004-b42d-9a4259869a80'), null=True),
        ),
    ]
