# Generated by Django 2.2.2 on 2019-11-07 22:29

from django.db import migrations, models
import uuid


class Migration(migrations.Migration):

    dependencies = [
        ('useraccount', '0014_auto_20191027_1302'),
    ]

    operations = [
        migrations.AlterField(
            model_name='userprofile',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('b6be3dc5-7d54-4eba-8dc6-22d1bd450066'), null=True),
        ),
    ]
