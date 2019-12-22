# Generated by Django 2.2.2 on 2019-12-22 17:08

from django.conf import settings
from django.db import migrations, models
import django.db.models.deletion
import shoppingcart.models


class Migration(migrations.Migration):

    dependencies = [
        ('lottery_shop', '0021_snsurl'),
        migrations.swappable_dependency(settings.AUTH_USER_MODEL),
        ('shoppingcart', '0006_auto_20191217_2313'),
    ]

    operations = [
        migrations.CreateModel(
            name='Favorite',
            fields=[
                ('id', models.AutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('slug', models.SlugField(default=shoppingcart.models.now_slug)),
                ('created_at', models.DateTimeField(auto_now_add=True)),
                ('product', models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='lottery_shop.Product')),
                ('user', models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, related_name='favorites', to=settings.AUTH_USER_MODEL)),
            ],
            options={
                'verbose_name': 'FavoriteProduct',
                'ordering': ['user', 'product'],
            },
        ),
    ]