# Generated by Django 2.2.2 on 2019-12-24 23:31

from django.db import migrations, models
import uuid


class Migration(migrations.Migration):

    dependencies = [
        ('exrate', '0164_auto_20191222_1708'),
    ]

    operations = [
        migrations.AlterField(
            model_name='bonus',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('d3c897ff-1148-4b14-95a1-30774ae7d6ea'), null=True),
        ),
        migrations.AlterField(
            model_name='bonusdetail',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('735a1e7a-d6a7-406d-ad26-9cd03197e0ec'), null=True),
        ),
    ]