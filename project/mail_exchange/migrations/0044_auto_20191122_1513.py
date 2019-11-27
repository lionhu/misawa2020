# Generated by Django 2.2.2 on 2019-11-22 15:13

import datetime
from django.db import migrations, models
import uuid


class Migration(migrations.Migration):

    dependencies = [
        ('mail_exchange', '0043_auto_20191122_1505'),
    ]

    operations = [
        migrations.AlterField(
            model_name='offer',
            name='due_at',
            field=models.DateTimeField(default=datetime.datetime(2019, 11, 25, 15, 13, 33, 782885)),
        ),
        migrations.AlterField(
            model_name='offer',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('7f36dd8a-cd35-447c-8f95-10d85e0432fb'), null=True),
        ),
        migrations.AlterField(
            model_name='order',
            name='due_at',
            field=models.DateTimeField(default=datetime.datetime(2019, 11, 25, 15, 13, 33, 781726)),
        ),
        migrations.AlterField(
            model_name='order',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('94792973-af42-421b-ad47-5dd1a2947417'), null=True),
        ),
        migrations.AlterField(
            model_name='transaction',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('ffffdfb5-1a86-4246-ae77-f928d501b84e'), null=True),
        ),
    ]