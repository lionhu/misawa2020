# Generated by Django 2.2.2 on 2019-11-28 22:58

from django.db import migrations, models
import uuid


class Migration(migrations.Migration):

    dependencies = [
        ('exrate', '0150_auto_20191124_1205'),
    ]

    operations = [
        migrations.AlterField(
            model_name='bonus',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('fc6c85fe-a3ed-4f8d-a555-73d636a3b5e1'), null=True),
        ),
        migrations.AlterField(
            model_name='bonusdetail',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('65f9e6c9-ab6b-4ef8-aa92-30988a245dfa'), null=True),
        ),
    ]
