# Generated by Django 2.2.2 on 2019-11-19 20:33

from django.db import migrations, models
import uuid


class Migration(migrations.Migration):

    dependencies = [
        ('useraccount', '0022_auto_20191119_2024'),
    ]

    operations = [
        migrations.AlterField(
            model_name='userprofile',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('3e56270a-1c13-4680-8af3-a1e4ed7d1554'), null=True),
        ),
    ]
