# Generated by Django 2.2.2 on 2019-10-25 21:45

import datetime
from django.db import migrations, models
import uuid


class Migration(migrations.Migration):

    dependencies = [
        ('mail_exchange', '0007_auto_20191025_2144'),
    ]

    operations = [
        migrations.AlterField(
            model_name='offer',
            name='due_at',
            field=models.DateTimeField(default=datetime.datetime(2019, 10, 28, 21, 45, 34, 976970)),
        ),
        migrations.AlterField(
            model_name='offer',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('286aa10b-2a82-4d74-9785-0d5657999f76'), null=True),
        ),
        migrations.AlterField(
            model_name='order',
            name='due_at',
            field=models.DateTimeField(default=datetime.datetime(2019, 10, 28, 21, 45, 34, 974375)),
        ),
        migrations.AlterField(
            model_name='order',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('53e522cc-cba4-4087-814f-b2db6b3ac97e'), null=True),
        ),
        migrations.AlterField(
            model_name='transaction',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('df3d14c0-63eb-44ad-ab7c-51fa8ce35d55'), null=True),
        ),
    ]