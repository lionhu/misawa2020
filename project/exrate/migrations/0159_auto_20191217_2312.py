# Generated by Django 2.2.2 on 2019-12-17 23:12

from django.db import migrations, models
import uuid


class Migration(migrations.Migration):

    dependencies = [
        ('exrate', '0158_auto_20191212_2026'),
    ]

    operations = [
        migrations.AlterField(
            model_name='bonus',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('3074636d-5908-4ca0-a86a-3a98fa512afe'), null=True),
        ),
        migrations.AlterField(
            model_name='bonusdetail',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('1b914205-1884-4452-967a-89ed0124516b'), null=True),
        ),
    ]
