# Generated by Django 2.2.2 on 2019-11-19 22:13

from django.db import migrations, models
import uuid


class Migration(migrations.Migration):

    dependencies = [
        ('useraccount', '0025_auto_20191119_2211'),
    ]

    operations = [
        migrations.AlterField(
            model_name='userprofile',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('7fbf0537-0bfe-4705-8720-6adef9f9983f'), null=True),
        ),
    ]