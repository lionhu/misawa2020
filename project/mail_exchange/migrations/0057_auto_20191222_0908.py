# Generated by Django 2.2.2 on 2019-12-22 09:08

import datetime
from django.db import migrations, models
import uuid


class Migration(migrations.Migration):

    dependencies = [
        ('mail_exchange', '0056_auto_20191218_2311'),
    ]

    operations = [
        migrations.AlterField(
            model_name='offer',
            name='due_at',
            field=models.DateTimeField(default=datetime.datetime(2019, 12, 25, 9, 8, 30, 222543)),
        ),
        migrations.AlterField(
            model_name='offer',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('1a52d9f8-e45b-43af-803b-81add88b43bb'), null=True),
        ),
        migrations.AlterField(
            model_name='order',
            name='due_at',
            field=models.DateTimeField(default=datetime.datetime(2019, 12, 25, 9, 8, 30, 221109)),
        ),
        migrations.AlterField(
            model_name='transaction',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('cda4b26c-be25-4767-9cf6-2fa9334b7336'), null=True),
        ),
    ]
