from square.client import Client
from square.configuration import Configuration


client = Client(
    access_token='EAAAEKq43mrNiHiJVdIIndwmWfzI2J9cR6zcjz-qrJuPRioMQ4-88RywvZg1xmA3',
    environment='sandbox',
)

customers_api = client.customers


payments_api=client.payments

payment={
    "idempotency_key": "UNIQUE_STRING",
    "amount_money": {
      "amount": 200,
      "currency": "JPY"
    },
    "source_id": "PAYMENT_SOURCE_ID",
    "reference_id": "123456",
    "order_id": "ORDER_ID"
}


payments_api.list_payments()


print(payments_api.list_payments())

# (1)Add customer
# body={
#     "given_name": "Haiguang",
#     "family_name": "Hu",
#     "email_address": "huhaiguang@me.com",
#     "address": {
#       "address_line_1": "500 Electric Ave",
#       "address_line_2": "Suite 600",
#       "locality": "New York",
#       "administrative_district_level_1": "NY",
#       "postal_code": "10003",
#       "country": "US"
#     },
#     "phone_number": "1-212-555-4240",
#     "reference_id": "YOUR_REFERENCE_ID",
#     "note": "a customer"
#   }


# result = customers_api.create_customer(body)


#(2)list all customers
# result = customers_api.list_customers()

# print(result)
# print(result.is_success)
