# Generated by Django 2.2.2 on 2019-10-22 21:00

import datetime
from django.db import migrations, models
import uuid


class Migration(migrations.Migration):

    dependencies = [
        ('mail_exchange', '0004_auto_20191022_1117'),
    ]

    operations = [
        migrations.AlterField(
            model_name='offer',
            name='due_at',
            field=models.DateTimeField(default=datetime.datetime(2019, 10, 25, 21, 0, 39, 118624)),
        ),
        migrations.AlterField(
            model_name='offer',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('97810ad2-e9ce-440c-ac15-ef14e33a5614'), null=True),
        ),
        migrations.AlterField(
            model_name='order',
            name='due_at',
            field=models.DateTimeField(default=datetime.datetime(2019, 10, 25, 21, 0, 39, 117686)),
        ),
        migrations.AlterField(
            model_name='order',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('5136c3f2-b19d-4b8d-bdbd-d2253b701790'), null=True),
        ),
        migrations.AlterField(
            model_name='transaction',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('17be08c2-ef10-409b-9ddf-ec6415bc3bde'), null=True),
        ),
    ]