    @extends('clients.theme-6.layouts.app')

    @section('title', __('api.title'))

    @section('content')
        <div id="block_api" class="theme6-api-block">
            <div class="block-api component_card">
                <div class="bg"></div>
                <div class="divider-top"></div>
                <div class="divider-bottom"></div>
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="card api-card">
                                <div class="table-bg">
                                    <div class="center-big-content-block api-content">
                                        <h4 class="mb-3">API Docs</h4>
                                        <div class="table-responsive mb-3">
                                            <table class="table api-table">
                                                <tbody>
                                                    <tr>
                                                        <td class="width-40">HTTP Method</td>
                                                        <td>POST</td>
                                                    </tr>
                                                    <tr>
                                                        <td>API URL</td>
                                                        <td>https://{{ getDomain() }}/api/v2</td>
                                                    </tr>
                                                    <tr>
                                                        <td>API Key</td>
                                                        <td>Get an API key on the <a href="{{ route('clients.account.index') }}">Account</a> page</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Response format</td>
                                                        <td>JSON</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <h4 class="mb-3">Service list</h4>
                                        <table class="table api-table mb-3">
                                            <thead>
                                                <tr>
                                                    <th class="width-40">Parameters</th>
                                                    <th>Description</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>key</td>
                                                    <td>Your API key</td>
                                                </tr>
                                                <tr>
                                                    <td>action</td>
                                                    <td>services</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div>
                                            <h4>Example response</h4>
                                        </div>
                                        <pre>[
    {
        "service": 1,
        "name": "Followers",
        "type": "Default",
        "category": "First Category",
        "rate": "0.90",
        "min": "50",
        "max": "10000",
        "refill": true,
        "cancel": true
    },
    {
        "service": 2,
        "name": "Comments",
        "type": "Custom Comments",
        "category": "Second Category",
        "rate": "8",
        "min": "10",
        "max": "1500",
        "refill": false,
        "cancel": true
    }
]
</pre>
                                        <h4 class="mb-3">Add order</h4>
                                        <form class="">
                                            <div class="form-group">
                                                <select class="form-control input-sm" id="service_type">
                                                    <option value="0">Default</option>
                                                    <option value="10">Package</option>
                                                    <option value="1">SEO</option>
                                                    <option value="2">Custom Comments</option>
                                                    <option value="9">Mentions</option>
                                                    <option value="4">Mentions Custom List</option>
                                                    <option value="6">Mentions Hashtag</option>
                                                    <option value="7">Mentions User Followers</option>
                                                    <option value="8">Mentions Media Likers</option>
                                                    <option value="14">Custom Comments Package</option>
                                                    <option value="15">Comment Likes</option>
                                                    <option value="17">Poll</option>
                                                    <option value="20">Invites from Groups</option>
                                                    <option value="100">Subscriptions</option>
                                                </select>
                                            </div>
                                        </form>
                                        <div id="type_0" style="">
                                            <table class="table api-table">
                                                <thead>
                                                    <tr>
                                                        <th class="width-40">Parameters</th>
                                                        <th>Description</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>key</td>
                                                        <td>Your API key</td>
                                                    </tr>
                                                    <tr>
                                                        <td>action</td>
                                                        <td>add</td>
                                                    </tr>
                                                    <tr>
                                                        <td>service</td>
                                                        <td>Service ID</td>
                                                    </tr>
                                                    <tr>
                                                        <td>link</td>
                                                        <td>Link to page</td>
                                                    </tr>
                                                    <tr>
                                                        <td>quantity</td>
                                                        <td>Needed quantity</td>
                                                    </tr>
                                                    <tr>
                                                        <td>runs (optional)</td>
                                                        <td>Runs to deliver</td>
                                                    </tr>
                                                    <tr>
                                                        <td>interval (optional)</td>
                                                        <td>Interval in minutes</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div id="type_10" style="display:none;">
                                            <table class="table api-table">
                                                <thead>
                                                    <tr>
                                                        <th class="width-40">Parameters</th>
                                                        <th>Description</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>key</td>
                                                        <td>Your API key</td>
                                                    </tr>
                                                    <tr>
                                                        <td>action</td>
                                                        <td>add</td>
                                                    </tr>
                                                    <tr>
                                                        <td>service</td>
                                                        <td>Service ID</td>
                                                    </tr>
                                                    <tr>
                                                        <td>link</td>
                                                        <td>Link to page</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div id="type_1" style="display:none;">
                                            <table class="table api-table">
                                                <thead>
                                                    <tr>
                                                        <th class="width-40">Parameters</th>
                                                        <th>Description</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>key</td>
                                                        <td>Your API key</td>
                                                    </tr>
                                                    <tr>
                                                        <td>action</td>
                                                        <td>add</td>
                                                    </tr>
                                                    <tr>
                                                        <td>service</td>
                                                        <td>Service ID</td>
                                                    </tr>
                                                    <tr>
                                                        <td>link</td>
                                                        <td>Link to page</td>
                                                    </tr>
                                                    <tr>
                                                        <td>quantity</td>
                                                        <td>Needed quantity</td>
                                                    </tr>
                                                    <tr>
                                                        <td>keywords</td>
                                                        <td>Keywords list separated by \r\n or \n</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div id="type_2" style="display:none;">
                                            <table class="table api-table">
                                                <thead>
                                                    <tr>
                                                        <th class="width-40">Parameters</th>
                                                        <th>Description</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>key</td>
                                                        <td>Your API key</td>
                                                    </tr>
                                                    <tr>
                                                        <td>action</td>
                                                        <td>add</td>
                                                    </tr>
                                                    <tr>
                                                        <td>service</td>
                                                        <td>Service ID</td>
                                                    </tr>
                                                    <tr>
                                                        <td>link</td>
                                                        <td>Link to page</td>
                                                    </tr>
                                                    <tr>
                                                        <td>comments</td>
                                                        <td>Comments list separated by \r\n or \n</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div id="type_9" style="display:none;">
                                            <table class="table api-table">
                                                <thead>
                                                    <tr>
                                                        <th class="width-40">Parameters</th>
                                                        <th>Description</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>key</td>
                                                        <td>Your API key</td>
                                                    </tr>
                                                    <tr>
                                                        <td>action</td>
                                                        <td>add</td>
                                                    </tr>
                                                    <tr>
                                                        <td>service</td>
                                                        <td>Service ID</td>
                                                    </tr>
                                                    <tr>
                                                        <td>link</td>
                                                        <td>Link to page</td>
                                                    </tr>
                                                    <tr>
                                                        <td>quantity</td>
                                                        <td>Needed quantity</td>
                                                    </tr>
                                                    <tr>
                                                        <td>usernames</td>
                                                        <td>Usernames list separated by \r\n or \n</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div id="type_4" style="display:none;">
                                            <table class="table api-table">
                                                <thead>
                                                    <tr>
                                                        <th class="width-40">Parameters</th>
                                                        <th>Description</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>key</td>
                                                        <td>Your API key</td>
                                                    </tr>
                                                    <tr>
                                                        <td>action</td>
                                                        <td>add</td>
                                                    </tr>
                                                    <tr>
                                                        <td>service</td>
                                                        <td>Service ID</td>
                                                    </tr>
                                                    <tr>
                                                        <td>link</td>
                                                        <td>Link to page</td>
                                                    </tr>
                                                    <tr>
                                                        <td>usernames</td>
                                                        <td>Usernames list separated by \r\n or \n</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div id="type_6" style="display:none;">
                                            <table class="table api-table">
                                                <thead>
                                                    <tr>
                                                        <th class="width-40">Parameters</th>
                                                        <th>Description</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>key</td>
                                                        <td>Your API key</td>
                                                    </tr>
                                                    <tr>
                                                        <td>action</td>
                                                        <td>add</td>
                                                    </tr>
                                                    <tr>
                                                        <td>service</td>
                                                        <td>Service ID</td>
                                                    </tr>
                                                    <tr>
                                                        <td>link</td>
                                                        <td>Link to page</td>
                                                    </tr>
                                                    <tr>
                                                        <td>quantity</td>
                                                        <td>Needed quantity</td>
                                                    </tr>
                                                    <tr>
                                                        <td>hashtag</td>
                                                        <td>Hashtag to scrape usernames from</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div id="type_7" style="display:none;">
                                            <table class="table api-table">
                                                <thead>
                                                    <tr>
                                                        <th class="width-40">Parameters</th>
                                                        <th>Description</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>key</td>
                                                        <td>Your API key</td>
                                                    </tr>
                                                    <tr>
                                                        <td>action</td>
                                                        <td>add</td>
                                                    </tr>
                                                    <tr>
                                                        <td>service</td>
                                                        <td>Service ID</td>
                                                    </tr>
                                                    <tr>
                                                        <td>link</td>
                                                        <td>Link to page</td>
                                                    </tr>
                                                    <tr>
                                                        <td>quantity</td>
                                                        <td>Needed quantity</td>
                                                    </tr>
                                                    <tr>
                                                        <td>username</td>
                                                        <td>URL to scrape followers from</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div id="type_8" style="display:none;">
                                            <table class="table api-table">
                                                <thead>
                                                    <tr>
                                                        <th class="width-40">Parameters</th>
                                                        <th>Description</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>key</td>
                                                        <td>Your API key</td>
                                                    </tr>
                                                    <tr>
                                                        <td>action</td>
                                                        <td>add</td>
                                                    </tr>
                                                    <tr>
                                                        <td>service</td>
                                                        <td>Service ID</td>
                                                    </tr>
                                                    <tr>
                                                        <td>link</td>
                                                        <td>Link to page</td>
                                                    </tr>
                                                    <tr>
                                                        <td>quantity</td>
                                                        <td>Needed quantity</td>
                                                    </tr>
                                                    <tr>
                                                        <td>media</td>
                                                        <td>Media URL to scrape likers from</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div id="type_100" style="display:none;">
                                            <table class="table api-table">
                                                <thead>
                                                    <tr>
                                                        <th class="width-40">Parameters</th>
                                                        <th>Description</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>key</td>
                                                        <td>Your API key</td>
                                                    </tr>
                                                    <tr>
                                                        <td>action</td>
                                                        <td>add</td>
                                                    </tr>
                                                    <tr>
                                                        <td>service</td>
                                                        <td>Service ID</td>
                                                    </tr>
                                                    <tr>
                                                        <td>username</td>
                                                        <td>Username</td>
                                                    </tr>
                                                    <tr>
                                                        <td>min</td>
                                                        <td>Quantity min</td>
                                                    </tr>
                                                    <tr>
                                                        <td>max</td>
                                                        <td>Quantity max</td>
                                                    </tr>
                                                    <tr>
                                                        <td>posts (optional)</td>
                                                        <td>Use this parameter if you want to limit the number of new
                                                            (future) posts that will be parsed and for which orders will be
                                                            created. If posts parameter is not set, the subscription will be
                                                            created for an unlimited number of posts.</td>
                                                    </tr>
                                                    <tr>
                                                        <td>old_posts (optional)</td>
                                                        <td>Number of existing posts that will be parsed and for which
                                                            orders will be created, can be used if this option is available
                                                            for the service.</td>
                                                    </tr>
                                                    <tr>
                                                        <td>delay</td>
                                                        <td>Delay in minutes. Possible values: 0, 5, 10, 15, 20, 30, 40, 50,
                                                            60, 90, 120, 150, 180, 210, 240, 270, 300, 360, 420, 480, 540,
                                                            600</td>
                                                    </tr>
                                                    <tr>
                                                        <td>expiry (optional)</td>
                                                        <td>Expiry date. Format d/m/Y</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div id="type_14" style="display:none;">
                                            <table class="table api-table">
                                                <thead>
                                                    <tr>
                                                        <th class="width-40">Parameters</th>
                                                        <th>Description</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>key</td>
                                                        <td>Your API key</td>
                                                    </tr>
                                                    <tr>
                                                        <td>action</td>
                                                        <td>add</td>
                                                    </tr>
                                                    <tr>
                                                        <td>service</td>
                                                        <td>Service ID</td>
                                                    </tr>
                                                    <tr>
                                                        <td>link</td>
                                                        <td>Link to page</td>
                                                    </tr>
                                                    <tr>
                                                        <td>comments</td>
                                                        <td>Comments list separated by \r\n or \n</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div id="type_15" style="display:none;">
                                            <table class="table api-table">
                                                <thead>
                                                    <tr>
                                                        <th class="width-40">Parameters</th>
                                                        <th>Description</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>key</td>
                                                        <td>Your API key</td>
                                                    </tr>
                                                    <tr>
                                                        <td>action</td>
                                                        <td>add</td>
                                                    </tr>
                                                    <tr>
                                                        <td>service</td>
                                                        <td>Service ID</td>
                                                    </tr>
                                                    <tr>
                                                        <td>link</td>
                                                        <td>Link to page</td>
                                                    </tr>
                                                    <tr>
                                                        <td>quantity</td>
                                                        <td>Needed quantity</td>
                                                    </tr>
                                                    <tr>
                                                        <td>username</td>
                                                        <td>Username of the comment owner</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div id="type_17" style="display:none;">
                                            <table class="table api-table">
                                                <thead>
                                                    <tr>
                                                        <th class="width-40">Parameters</th>
                                                        <th>Description</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>key</td>
                                                        <td>Your API key</td>
                                                    </tr>
                                                    <tr>
                                                        <td>action</td>
                                                        <td>add</td>
                                                    </tr>
                                                    <tr>
                                                        <td>service</td>
                                                        <td>Service ID</td>
                                                    </tr>
                                                    <tr>
                                                        <td>link</td>
                                                        <td>Link to page</td>
                                                    </tr>
                                                    <tr>
                                                        <td>quantity</td>
                                                        <td>Needed quantity</td>
                                                    </tr>
                                                    <tr>
                                                        <td>answer_number</td>
                                                        <td>Answer number of the poll</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div id="type_20" style="display:none;">
                                            <table class="table api-table">
                                                <thead>
                                                    <tr>
                                                        <th class="width-40">Parameters</th>
                                                        <th>Description</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>key</td>
                                                        <td>Your API key</td>
                                                    </tr>
                                                    <tr>
                                                        <td>action</td>
                                                        <td>add</td>
                                                    </tr>
                                                    <tr>
                                                        <td>service</td>
                                                        <td>Service ID</td>
                                                    </tr>
                                                    <tr>
                                                        <td>link</td>
                                                        <td>Link to page</td>
                                                    </tr>
                                                    <tr>
                                                        <td>quantity</td>
                                                        <td>Needed quantity</td>
                                                    </tr>
                                                    <tr>
                                                        <td>groups</td>
                                                        <td>Groups list separated by \r\n or \n</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div>
                                            <h4>Example response</h4>
                                        </div>
                                        <pre>{
    "order": 23501
}
</pre>
                                        <h4 class="mb-3">Order status</h4>
                                        <table class="table api-table mb-3">
                                            <thead>
                                                <tr>
                                                    <th class="width-40">Parameters</th>
                                                    <th>Description</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>key</td>
                                                    <td>Your API key</td>
                                                </tr>
                                                <tr>
                                                    <td>action</td>
                                                    <td>status</td>
                                                </tr>
                                                <tr>
                                                    <td>order</td>
                                                    <td>Order ID</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div>
                                            <h4>Example response</h4>
                                        </div>
                                        <pre>{
    "charge": "0.27819",
    "start_count": "3572",
    "status": "Partial",
    "remains": "157",
    "currency": "USD"
}
</pre>
                                        <h4 class="mb-3">Multiple orders status</h4>
                                        <table class="table api-table mb-3">
                                            <thead>
                                                <tr>
                                                    <th class="width-40">Parameters</th>
                                                    <th>Description</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>key</td>
                                                    <td>Your API key</td>
                                                </tr>
                                                <tr>
                                                    <td>action</td>
                                                    <td>status</td>
                                                </tr>
                                                <tr>
                                                    <td>orders</td>
                                                    <td>Order IDs (separated by a comma, up to 100 IDs)</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div>
                                            <h4>Example response</h4>
                                        </div>
                                        <pre>{
    "1": {
        "charge": "0.27819",
        "start_count": "3572",
        "status": "Partial",
        "remains": "157",
        "currency": "USD"
    },
    "10": {
        "error": "Incorrect order ID"
    },
    "100": {
        "charge": "1.44219",
        "start_count": "234",
        "status": "In progress",
        "remains": "10",
        "currency": "USD"
    }
}
</pre>
                                        <h4 class="mb-3">Create refill</h4>
                                        <table class="table api-table mb-3">
                                            <thead>
                                                <tr>
                                                    <th class="width-40">Parameters</th>
                                                    <th>Description</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>key</td>
                                                    <td>Your API key</td>
                                                </tr>
                                                <tr>
                                                    <td>action</td>
                                                    <td>refill</td>
                                                </tr>
                                                <tr>
                                                    <td>order</td>
                                                    <td>Order ID</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div>
                                            <h4>Example response</h4>
                                        </div>
                                        <pre>{
    "refill": "1"
}
</pre>
                                        <h4 class="mb-3">Create multiple refill</h4>
                                        <table class="table api-table mb-3">
                                            <thead>
                                                <tr>
                                                    <th class="width-40">Parameters</th>
                                                    <th>Description</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>key</td>
                                                    <td>Your API key</td>
                                                </tr>
                                                <tr>
                                                    <td>action</td>
                                                    <td>refill</td>
                                                </tr>
                                                <tr>
                                                    <td>orders</td>
                                                    <td>Order IDs (separated by a comma, up to 100 IDs)</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div>
                                            <h4>Example response</h4>
                                        </div>
                                        <pre>[
    {
        "order": 1,
        "refill": 1
    },
    {
        "order": 2,
        "refill": 2
    },
    {
        "order": 3,
        "refill": {
            "error": "Incorrect order ID"
        }
    }
]
</pre>
                                        <h4 class="mb-3">Get refill status</h4>
                                        <table class="table api-table mb-3">
                                            <thead>
                                                <tr>
                                                    <th class="width-40">Parameters</th>
                                                    <th>Description</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>key</td>
                                                    <td>Your API key</td>
                                                </tr>
                                                <tr>
                                                    <td>action</td>
                                                    <td>refill_status</td>
                                                </tr>
                                                <tr>
                                                    <td>refill</td>
                                                    <td>Refill ID</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div>
                                            <h4>Example response</h4>
                                        </div>
                                        <pre>{
    "status": "Completed"
}
</pre>
                                        <h4 class="mb-3">Get multiple refill status</h4>
                                        <table class="table api-table mb-3">
                                            <thead>
                                                <tr>
                                                    <th class="width-40">Parameters</th>
                                                    <th>Description</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>key</td>
                                                    <td>Your API key</td>
                                                </tr>
                                                <tr>
                                                    <td>action</td>
                                                    <td>refill_status</td>
                                                </tr>
                                                <tr>
                                                    <td>refills</td>
                                                    <td>Refill IDs (separated by a comma, up to 100 IDs)</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div>
                                            <h4>Example response</h4>
                                        </div>
                                        <pre>[
    {
        "refill": 1,
        "status": "Completed"
    },
    {
        "refill": 2,
        "status": "Rejected"
    },
    {
        "refill": 3,
        "status": {
            "error": "Refill not found"
        }
    }
]
</pre>
                                        <h4 class="mb-3">Create cancel</h4>
                                        <table class="table api-table mb-3">
                                            <thead>
                                                <tr>
                                                    <th class="width-40">Parameters</th>
                                                    <th>Description</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>key</td>
                                                    <td>Your API key</td>
                                                </tr>
                                                <tr>
                                                    <td>action</td>
                                                    <td>cancel</td>
                                                </tr>
                                                <tr>
                                                    <td>orders</td>
                                                    <td>Order IDs (separated by a comma, up to 100 IDs)</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div>
                                            <h4>Example response</h4>
                                        </div>
                                        <pre>[
    {
        "order": 9,
        "cancel": {
            "error": "Incorrect order ID"
        }
    },
    {
        "order": 2,
        "cancel": 1
    }
]
</pre>
                                        <h4 class="mb-3">User balance</h4>
                                        <table class="table api-table mb-3">
                                            <thead>
                                                <tr>
                                                    <th class="width-40">Parameters</th>
                                                    <th>Description</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>key</td>
                                                    <td>Your API key</td>
                                                </tr>
                                                <tr>
                                                    <td>action</td>
                                                    <td>balance</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div>
                                            <h4>Example response</h4>
                                        </div>
                                        <pre>{
    "balance": "100.84292",
    "currency": "USD"
}
</pre>
                                        <a href="/example.txt" class="btn btn-big-secondary" target="_blank">Example of
                                            PHP code</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <style>
#block_api.theme6-api-block { width:100%; min-width:0; padding:30px 0; position:relative; }
#block_api .block-api, #block_api .api-card, #block_api .api-content { width:100%; max-width:none; }
#block_api .api-card { border:0; box-shadow:none; }
#block_api .api-content { padding:0; }
#block_api .api-content h4 { margin-top:24px; }
#block_api .api-table { width:100%; table-layout:auto; }
#block_api .api-table th:first-child, #block_api .api-table td:first-child { width:40%; }
#block_api pre { max-width:100%; overflow:auto; white-space:pre-wrap; word-break:break-word; padding:16px; border-radius:8px; background:#f5f6fa; }
#block_api .api-key-value { font-family:monospace; font-weight:700; word-break:break-all; }
@media (max-width: 768px) { #block_api { padding:16px 0; } #block_api .api-table { font-size:13px; } #block_api .api-table th:first-child, #block_api .api-table td:first-child { width:35%; } }
</style>@endsection
