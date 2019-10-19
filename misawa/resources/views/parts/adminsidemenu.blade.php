<!-- Sidebar
============================================= -->
<div class="sidebar nobottommargin">
    <div class="sidebar-widgets-wrap">
        <div class="widget clearfix">
            <h4>Message to <span>Members</span></h4>
            <div class="input-group divcenter">
                <input type="text" class="form-control" v-model="toAllMessage" @keyup.enter="sendmessage" placeholder="message to all members" required="">
                <span class="input-group-btn">
											<button class="btn btn-success" type="button" v-on:click="sendmessage" ><i class="icon-email2"></i></button>
										</span>
            </div>
        </div>
    </div>
</div><!-- .sidebar end -->
