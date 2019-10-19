from rest_framework.exceptions import APIException

class ObjectNotFound(APIException):
    status_code = 503
    default_detail = 'Service temporarily unavailable, try again later.'
    default_code = 'service_unavailable'


    def __init__(self, code, error, default_code):
        self.status_code = code
        self.default_detail = error
        self.default_code= default_code



class InvalidUserSignupParams(APIException):
    
    def __init__(self, code, error, default_code):
        self.status_code = code
        self.default_detail = error
        self.default_code= default_code