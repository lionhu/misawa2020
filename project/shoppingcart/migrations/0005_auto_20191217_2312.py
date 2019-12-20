# Generated by Django 2.2.2 on 2019-12-17 23:12

from django.db import migrations, models
import django.utils.timezone


class Migration(migrations.Migration):

    dependencies = [
        ('shoppingcart', '0004_order_num'),
    ]

    operations = [
        migrations.AddField(
            model_name='order',
            name='paid_at',
            field=models.DateTimeField(auto_now_add=True, default=django.utils.timezone.now),
            preserve_default=False,
        ),
        migrations.AddField(
            model_name='order',
            name='paymethon',
            field=models.CharField(choices=[('bank', 'bank'), ('wechat', 'wechat'), ('alipay', 'alipay'), ('line', 'line'), ('jcoin', 'jcoin')], default='bank', max_length=10),
        ),
        migrations.AddField(
            model_name='order',
            name='paystatus',
            field=models.CharField(choices=[('unpaid', 'unpaid'), ('paid', 'paid')], default='unpaid', max_length=10),
        ),
    ]