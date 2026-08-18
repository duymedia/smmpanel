    @extends('clients.theme-6.layouts.app')

    @section('title', __('newOrder.title'))

    @section('content')
        <div id="block_118">
            <div class="block-bg"></div>
            <div class="container-fluid">
                <div class="orders-refunds ">
                    <div class="row">
                        <div class="col">
                            <div class="component_alert mb-3">
                                <div class="alert alert-info alert-dismissible fade show mb-3" role="alert">
                                    Refund details are available for the past 90 days.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="margin-tab">
                                <div class="component_tabs">
                                    <div class="">
                                        <ul class="nav nav-pills tab">
                                            <li class="nav-item">
                                                <a class="nav-link active" href="/orders/refunds">All</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link "
                                                    href="/orders/refunds?order_status=canceled">Canceled</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link " href="/orders/refunds?order_status=partial">Partial</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="margin-search component_card">
                                <div class="card">
                                    <div class="component_form_group component_button_search">
                                        <div class="">
                                            <form action="/orders/refunds" method="get" id="history-search">
                                                <div class="input-group">
                                                    <input type="text" name="search" class="form-control" value=""
                                                        placeholder="Search">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-big-secondary" type="submit">
                                                            <span class="fas fa-search"></span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="margin-table">
                                <div class="table-bg component_table ">
                                    <div class="table-wr table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>Refunded amount</th>
                                                    <th>Order status</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td data-label="Order ID">
                                                        <a href="/orders?search=7625429">7625429</a>
                                                    </td>
                                                    <td data-label="Refunded amount" nowrap="">
                                                        +0.014625
                                                    </td>
                                                    <td data-label="Order status">
                                                        Canceled
                                                    </td>
                                                    <td data-label="Date">
                                                        2026-05-07 12:46:58
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td data-label="Order ID">
                                                        <a href="/orders?search=7625272">7625272</a>
                                                    </td>
                                                    <td data-label="Refunded amount" nowrap="">
                                                        +0.03101
                                                    </td>
                                                    <td data-label="Order status">
                                                        Partial
                                                    </td>
                                                    <td data-label="Date">
                                                        2026-05-03 12:45:11
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5">
                            <nav class="component_pagination">
                                <div class="">
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
