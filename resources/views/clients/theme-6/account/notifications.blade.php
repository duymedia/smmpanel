    @extends('clients.theme-6.layouts.app')

    @section('title', __('newOrder.title'))

    @section('content')
        <div id="block_124">
            <div class="block-bg"></div>
            <div class="container">
                <div class="notifications ">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="notifications-tabs margin-card">
                                <div class="component_tabs ">
                                    <ul class="nav nav-pills tab">
                                        <li class="nav-item">
                                            <a class="nav-link" href="/account">General</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active" href="/notifications">Notifications</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="component_card">
                                <div class="card margin-card">
                                    <div id="confirmEmailSuccess"
                                        class="alert alert-dismissible alert-success hidden mb-3 ">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <!--- Success text --->
                                    </div>
                                    <div id="confirmEmailError" class="alert alert-dismissible alert-danger hidden mb-3 ">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <!--- Error text --->
                                    </div>
                                    <h5>Email confirmation</h5>
                                    <p class="mb-2">Your e-mail address is unconfirmed. Please confirm your email address
                                        to receive email notifications.</p>
                                    <form action="/notifications/confirm-email" method="post">
                                        <input type="hidden" name="_csrf"
                                            value="RKYqc-oA4YworwBiy4kjWxQv-grM9Lc3SnlanWX7RDo0wx8XrEuFz0LAcyr_62sSYn6OW7uF6GUaEWPpJLcDUg==">
                                        <div class="component_button_primary">
                                            <button type="submit" class="btn btn-big-primary btn-block">Confirm</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="margin-card">
                                <form action="" method="post">
                                    <div class="table-bg component_table ">
                                        <div class="table-wr table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Notification</th>
                                                        <th>Email</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>API key changed</td>
                                                        <td>
                                                            <span class="component_checkbox">
                                                                <input type="hidden"
                                                                    name="NotificationsForm[notifications][email][10]"
                                                                    value="0">
                                                                <div class="form-group__checkbox">
                                                                    <label class="form-group__checkbox-label"
                                                                        data-toggle="tooltip" data-placement="top"
                                                                        title=""
                                                                        data-original-title="Confirm your email to receive email notifications.">
                                                                        <input type="checkbox"
                                                                            name="NotificationsForm[notifications][email][10]"
                                                                            checked="checked" disabled="" value="1">
                                                                        <span class="checkmark"></span>
                                                                    </label>
                                                                </div>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>New message</td>
                                                        <td>
                                                            <span class="component_checkbox">
                                                                <input type="hidden"
                                                                    name="NotificationsForm[notifications][email][8]"
                                                                    value="0">
                                                                <div class="form-group__checkbox">
                                                                    <label class="form-group__checkbox-label"
                                                                        data-toggle="tooltip" data-placement="top"
                                                                        title=""
                                                                        data-original-title="Confirm your email to receive email notifications.">
                                                                        <input type="checkbox"
                                                                            name="NotificationsForm[notifications][email][8]"
                                                                            checked="checked" disabled="" value="1">
                                                                        <span class="checkmark"></span>
                                                                    </label>
                                                                </div>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3">
                                                            <input type="hidden" name="_csrf"
                                                                value="RKYqc-oA4YworwBiy4kjWxQv-grM9Lc3SnlanWX7RDo0wx8XrEuFz0LAcyr_62sSYn6OW7uF6GUaEWPpJLcDUg==">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
