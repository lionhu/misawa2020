# Generated by Django 2.2.2 on 2019-11-22 12:58

from django.db import migrations, models
import uuid


class Migration(migrations.Migration):

    dependencies = [
        ('exrate', '0146_auto_20191122_1004'),
    ]

    operations = [
        migrations.AlterField(
            model_name='bonus',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('d1af613f-6602-4373-af45-1260114f2f7b'), null=True),
        ),
        migrations.AlterField(
            model_name='bonusdetail',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('955ab88a-948e-4a0e-9e7b-94bd0bd4d407'), null=True),
        ),
    ]