# Generated by Django 2.2.2 on 2019-11-21 21:34

from django.db import migrations, models
import uuid


class Migration(migrations.Migration):

    dependencies = [
        ('useraccount', '0038_auto_20191121_2132'),
    ]

    operations = [
        migrations.AlterField(
            model_name='userprofile',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('193719fc-7b60-41ec-81fb-55ce21fe8fc8'), null=True),
        ),
    ]