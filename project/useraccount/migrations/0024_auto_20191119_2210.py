# Generated by Django 2.2.2 on 2019-11-19 22:10

from django.db import migrations, models
import uuid


class Migration(migrations.Migration):

    dependencies = [
        ('useraccount', '0023_auto_20191119_2033'),
    ]

    operations = [
        migrations.AlterField(
            model_name='userprofile',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('8621ce5b-6502-408d-bace-2b4ca70d537e'), null=True),
        ),
    ]
