# Generated by Django 2.2.2 on 2019-11-22 10:04

import datetime
from django.db import migrations, models
import uuid


class Migration(migrations.Migration):

    dependencies = [
        ('mail_exchange', '0040_auto_20191122_1002'),
    ]

    operations = [
        migrations.AlterField(
            model_name='offer',
            name='due_at',
            field=models.DateTimeField(default=datetime.datetime(2019, 11, 25, 10, 4, 25, 913877)),
        ),
        migrations.AlterField(
            model_name='offer',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('4c33a230-438d-4bf1-8928-7a1d33c63083'), null=True),
        ),
        migrations.AlterField(
            model_name='order',
            name='due_at',
            field=models.DateTimeField(default=datetime.datetime(2019, 11, 25, 10, 4, 25, 912454)),
        ),
        migrations.AlterField(
            model_name='order',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('87d629ff-ed04-4215-a814-75175349de61'), null=True),
        ),
        migrations.AlterField(
            model_name='transaction',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('d8a320cf-e7eb-473a-a3d1-76bf05223015'), null=True),
        ),
    ]
