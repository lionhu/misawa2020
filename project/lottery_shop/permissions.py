from rest_framework import permissions
from django.conf import settings
from django.contrib.auth.models import User
import logging

logger=logging.getLogger("error_logger")

class IsOwnerOrReadOnly(permissions.BasePermission):
    """
    自定义权限只允许对象的所有者编辑它。
    """

    def has_object_permission(self, request, view, obj):
        # 读取权限允许任何请求，
        # 所以我们总是允许GET，HEAD或OPTIONS请求。
        if request.method in permissions.SAFE_METHODS:
            return True

        # 只有该snippet的所有者才允许写权限。
        return obj.owner == request.user


class IsAdminOrOwner(permissions.BasePermission):
    """
    自定义权限只允许对象的所有者编辑它。
    """
    def has_permission(self, request, view):
        # 读取权限允许任何请求，
        # 所以我们总是允许GET，HEAD或OPTIONS请求。
        if request.method in permissions.SAFE_METHODS:
            return True


    def has_object_permission(self, request, view, obj):

        admin = User.objects.get(pk=settings.ADMIN_ROOT_ID)

        if request.user == obj.owner:
            return True

        if request.user == admin:
            return True



class IsAdminOrReadOnly(permissions.BasePermission):
    """
    自定义权限只允许对象的所有者编辑它。
    """
    def has_permission(self, request, view):
        # 读取权限允许任何请求，
        # 所以我们总是允许GET，HEAD或OPTIONS请求。
        if request.method in permissions.SAFE_METHODS:
            return True

        admin = User.objects.get(pk=settings.ADMIN_ROOT_ID)

        if request.user == admin:
            return True


    def has_object_permission(self, request, view, obj):


        if request.method in permissions.SAFE_METHODS:
            return True

        admin = User.objects.get(pk=settings.ADMIN_ROOT_ID)
        if request.user == admin:
            return True


class IsAdmin(permissions.BasePermission):
    """
    自定义权限只允许对象的所有者编辑它。
    """

    def has_permission(self, request, view):

        admin = User.objects.get(pk=settings.ADMIN_ROOT_ID)

        if request.user == admin:
            return True











