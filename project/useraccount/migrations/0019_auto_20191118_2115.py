# Generated by Django 2.2.2 on 2019-11-18 21:15

from django.db import migrations, models
import uuid


class Migration(migrations.Migration):

    dependencies = [
        ('useraccount', '0018_merge_20191112_2018'),
    ]

    operations = [
        migrations.AlterField(
            model_name='userprofile',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('7a089460-e4cd-4d10-940d-9d61110eaee1'), null=True),
        ),
    ]
