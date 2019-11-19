# Generated by Django 2.2.2 on 2019-11-19 20:33

import datetime
from django.db import migrations, models
import uuid


class Migration(migrations.Migration):

    dependencies = [
        ('mail_exchange', '0020_auto_20191119_2024'),
    ]

    operations = [
        migrations.AlterField(
            model_name='offer',
            name='due_at',
            field=models.DateTimeField(default=datetime.datetime(2019, 11, 22, 20, 33, 34, 366277)),
        ),
        migrations.AlterField(
            model_name='offer',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('749387c7-831e-4c46-a9fc-5047d212f10a'), null=True),
        ),
        migrations.AlterField(
            model_name='order',
            name='due_at',
            field=models.DateTimeField(default=datetime.datetime(2019, 11, 22, 20, 33, 34, 365110)),
        ),
        migrations.AlterField(
            model_name='order',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('ea2ecd64-9a98-40b5-9417-b5f3e18ed15b'), null=True),
        ),
        migrations.AlterField(
            model_name='transaction',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('8e002bba-ab2c-4d83-bc0c-8a573a1f3bbf'), null=True),
        ),
    ]
