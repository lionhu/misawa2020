# Generated by Django 2.2.2 on 2019-11-19 20:33

from django.db import migrations, models
import uuid


class Migration(migrations.Migration):

    dependencies = [
        ('exrate', '0125_auto_20191119_2024'),
    ]

    operations = [
        migrations.AlterField(
            model_name='bonus',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('0127394a-5693-4a42-920d-6e44a6071d5d'), null=True),
        ),
        migrations.AlterField(
            model_name='bonusdetail',
            name='slug',
            field=models.SlugField(blank=True, default=uuid.UUID('def16e94-466b-4452-a0a7-62995a324642'), null=True),
        ),
    ]
