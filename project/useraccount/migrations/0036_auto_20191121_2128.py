# Generated by Django 2.2.2 on 2019-11-21 21:28

from django.db import migrations, models
import uuid


class Migration(migrations.Migration):

    dependencies = [
        ('useraccount', '0035_auto_20191121_2125'),
    ]

    operations = [
        migrations.AlterField(
            model_name='userprofile',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('df56edc8-6dde-42e2-8048-4b8b9d665871'), null=True),
        ),
    ]