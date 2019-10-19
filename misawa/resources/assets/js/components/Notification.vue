<template>
    <li class="sub-menu"><a href="shop.html" class="sf-with-ul">Notification<span>22</span></a>
        <ul style="display: none;">
            <li>

            </li>
        </ul>
    </li>
</template>

<script>
    export default {
        props: ['unreads','userId'],
        mounted: function () {
            Echo.private('App.User.' + this.userId)
                .notification((notification)=>{
                    console.log(notification);
                });
        }
    }
</script>
