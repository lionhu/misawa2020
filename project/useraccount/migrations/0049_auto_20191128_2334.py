# Generated by Django 2.2.2 on 2019-11-28 23:34

from django.db import migrations, models
import uuid


class Migration(migrations.Migration):

    dependencies = [
        ('useraccount', '0048_auto_20191128_2258'),
    ]

    operations = [
        migrations.AlterField(
            model_name='userprofile',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('bf5cd308-9b2e-4e31-88da-1d5c860de9d5'), null=True),
        ),
    ]
