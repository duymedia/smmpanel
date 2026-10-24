@extends('clients.theme-6.layouts.app')

@section('title', __('orders.title'))

@section('content')
   
     <div id="block_117"><div class="block-bg"></div><div class="container-fluid"><div class="orders-history ">
    <div class="row">
        <div class="col">
            <div class="orders-history__margin-tab">
                <div class="component_status_tabs">
                    <div class="">
                        <ul class="nav nav-pills tab">
                            <li class="nav-item">
                                <a class="nav-link active" href="/orders">All</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="/orders/pending">Pending</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="/orders/inprogress">In progress</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="/orders/completed">Completed</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="/orders/partial">Partial</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="/orders/processing">Processing</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="/orders/canceled">Canceled</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="orders-history__margin-search component_card">
                <div class="card">
                    <div class="component_form_group component_button_search">
                        <div class="">
                            <form action="/orders" method="get" id="history-search">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" value="" placeholder="Search">
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
            <div class="orders-history__margin-table">
                <div class="table-bg component_table ">
                    <div class="table-wr table-responsive">
                        <table class="table theme-6-orders-table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Link</th>
                                <th>Charge</th>
                                <th class="nowrap">Start count</th>
                                <th>Quantity</th>
                                <th>Service</th>
                                <th>Status</th>
                                <th>Remains</th>
                                                            </tr>
                            </thead>
                            <tbody>
                                                                                                <tr>
                                        <td data-label="ID">12614411</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-09-05</span>
                                            <span class="nowrap">04:12:10</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=2131" target="_blank">2131</a>
                                                                                    </td>
                                        <td data-label="Charge">0.00009</td>
                                        <td data-label="Start count" class="nowrap"></td>
                                        <td data-label="Quantity">100</td>
                                        <td data-label="Service" class="table-service">29 — Instagram Video Views [Worldwide Profile] [Refill: No]</td>
                                        <td data-label="Status" nowrap="">
                                            Pending                                        </td>
                                        <td data-label="Remains">100</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">11234165</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-07-27</span>
                                            <span class="nowrap">03:48:48</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=duyhopham5" target="_blank">duyhopham5</a>
                                                                                    </td>
                                        <td data-label="Charge">0.04013</td>
                                        <td data-label="Start count" class="nowrap">12946</td>
                                        <td data-label="Quantity">100</td>
                                        <td data-label="Service" class="table-service">6570 — TikTok  Followers [Refill: No] [Cheapest]</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">0</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">9236926</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-06-09</span>
                                            <span class="nowrap">22:51:42</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=dazgtom.28" target="_blank">dazgtom.28</a>
                                                                                    </td>
                                        <td data-label="Charge">0.36153</td>
                                        <td data-label="Start count" class="nowrap">3317</td>
                                        <td data-label="Quantity">100</td>
                                        <td data-label="Service" class="table-service">32 — TikTok Followers [HQ Profiles] [Refill: No] [Low Drop] [Instant Start]</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">0</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">9074768</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-06-06</span>
                                            <span class="nowrap">13:46:53</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=https%3A%2F%2Fwww.tiktok.com%2F%40dazgtom.28" target="_blank">https://www.tiktok.com/@dazgtom.28</a>
                                                                                    </td>
                                        <td data-label="Charge">0.36153</td>
                                        <td data-label="Start count" class="nowrap">3218</td>
                                        <td data-label="Quantity">100</td>
                                        <td data-label="Service" class="table-service">32 — TikTok Followers [HQ Profiles] [Refill: No] [Low Drop] [Instant Start]</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">0</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">7630759</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-05-03</span>
                                            <span class="nowrap">05:44:44</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=https%3A%2F%2Fwww.tiktok.com%2F%40quocduy_11204" target="_blank">https://www.tiktok.com/@quocduy_11204</a>
                                                                                    </td>
                                        <td data-label="Charge">0.0145747</td>
                                        <td data-label="Start count" class="nowrap">12787</td>
                                        <td data-label="Quantity">100</td>
                                        <td data-label="Service" class="table-service">4450 — TikTok Followers [Max 1M] [LQ Profile] [Refill: No] [Instant Start] 100K/Day</td>
                                        <td data-label="Status" nowrap="">
                                            Partial                                        </td>
                                        <td data-label="Remains">53</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">7625429</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-05-03</span>
                                            <span class="nowrap">02:20:44</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=https%3A%2F%2Fwww.tiktok.com%2F%40duyhopham5" target="_blank">https://www.tiktok.com/@duyhopham5</a>
                                                                                    </td>
                                        <td data-label="Charge">0.00</td>
                                        <td data-label="Start count" class="nowrap">0</td>
                                        <td data-label="Quantity">50</td>
                                        <td data-label="Service" class="table-service">4455 — TikTok Followers [Max 1M] [LQ Profile] [Refill: No] [Instant Start] 100K/Day</td>
                                        <td data-label="Status" nowrap="">
                                            Canceled                                        </td>
                                        <td data-label="Remains">50</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">7625272</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-05-03</span>
                                            <span class="nowrap">02:14:08</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=duyhopham5" target="_blank">duyhopham5</a>
                                                                                    </td>
                                        <td data-label="Charge">0.00</td>
                                        <td data-label="Start count" class="nowrap">12473</td>
                                        <td data-label="Quantity">100</td>
                                        <td data-label="Service" class="table-service">4450 — TikTok Followers [Max 1M] [LQ Profile] [Refill: No] [Instant Start] 100K/Day</td>
                                        <td data-label="Status" nowrap="">
                                            Partial                                        </td>
                                        <td data-label="Remains">100</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">7624770</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-05-03</span>
                                            <span class="nowrap">01:52:00</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=duyhopham5" target="_blank">duyhopham5</a>
                                                                                    </td>
                                        <td data-label="Charge">0.003101</td>
                                        <td data-label="Start count" class="nowrap">12463</td>
                                        <td data-label="Quantity">10</td>
                                        <td data-label="Service" class="table-service">4450 — TikTok Followers [Max 1M] [LQ Profile] [Refill: No] [Instant Start] 100K/Day</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">0</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">6669509</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-04-09</span>
                                            <span class="nowrap">06:04:06</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=https%3A%2F%2Fwww.tiktok.com%2F%40xusohuongtra20tn%3F_r%3D1%26amp%3B_t%3DZS-95OZMBKVoE1" target="_blank">https://www.tiktok.com/@xusohuongtra20tn?_r=1&amp;_t=ZS-95OZMBKVoE1</a>
                                                                                    </td>
                                        <td data-label="Charge">0.1449</td>
                                        <td data-label="Start count" class="nowrap">2</td>
                                        <td data-label="Quantity">100</td>
                                        <td data-label="Service" class="table-service">5375 — TikTok Followers [Refill: No] [Cheapest]</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">0</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">6369126</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-04-01</span>
                                            <span class="nowrap">20:49:17</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=https%3A%2F%2Fwww.tiktok.com%2F%40suane._.n%3Fis_from_webapp%3D1%26amp%3Bsender_device%3Dpc" target="_blank">https://www.tiktok.com/@suane._.n?is_from_webapp=1&amp;sender_device=pc</a>
                                                                                    </td>
                                        <td data-label="Charge">0.5796</td>
                                        <td data-label="Start count" class="nowrap">601</td>
                                        <td data-label="Quantity">400</td>
                                        <td data-label="Service" class="table-service">5375 — TikTok Followers [Refill: No] [Cheapest]</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">+17</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">6351380</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-04-01</span>
                                            <span class="nowrap">11:01:53</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=https%3A%2F%2Fwww.tiktok.com%2F%40suane._.n%3Fis_from_webapp%3D1%26amp%3Bsender_device%3Dpc" target="_blank">https://www.tiktok.com/@suane._.n?is_from_webapp=1&amp;sender_device=pc</a>
                                                                                    </td>
                                        <td data-label="Charge">0.7245</td>
                                        <td data-label="Start count" class="nowrap">22</td>
                                        <td data-label="Quantity">500</td>
                                        <td data-label="Service" class="table-service">5375 — TikTok Followers [Refill: No] [Cheapest]</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">0</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">6322800</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-03-31</span>
                                            <span class="nowrap">17:08:05</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=https%3A%2F%2Fwww.tiktok.com%2F%40qunh.oanh888%3F_r%3D1%26amp%3B_t%3DZS-95A3LDKm8vv" target="_blank">https://www.tiktok.com/@qunh.oanh888?_r=1&amp;_t=ZS-95A3LDKm8vv</a>
                                                                                    </td>
                                        <td data-label="Charge">1.449</td>
                                        <td data-label="Start count" class="nowrap">1454</td>
                                        <td data-label="Quantity">1000</td>
                                        <td data-label="Service" class="table-service">5375 — TikTok Followers [Refill: No] [Cheapest]</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">+26</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">6295260</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-03-31</span>
                                            <span class="nowrap">03:30:03</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=https%3A%2F%2Fwww.tiktok.com%2F%40kiennn201%3F_r%3D1%26amp%3B_t%3DZS-9595gYHhlSM" target="_blank">https://www.tiktok.com/@kiennn201?_r=1&amp;_t=ZS-9595gYHhlSM</a>
                                                                                    </td>
                                        <td data-label="Charge">1.449</td>
                                        <td data-label="Start count" class="nowrap">196</td>
                                        <td data-label="Quantity">1000</td>
                                        <td data-label="Service" class="table-service">5375 — TikTok Followers [Refill: No] [Cheapest]</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">0</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">6295248</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-03-31</span>
                                            <span class="nowrap">03:29:40</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=https%3A%2F%2Fwww.tiktok.com%2F%40yennhipassdo999%3F_r%3D1%26amp%3B_t%3DZS-9595cCKvSZb" target="_blank">https://www.tiktok.com/@yennhipassdo999?_r=1&amp;_t=ZS-9595cCKvSZb</a>
                                                                                    </td>
                                        <td data-label="Charge">2.898</td>
                                        <td data-label="Start count" class="nowrap">513</td>
                                        <td data-label="Quantity">2000</td>
                                        <td data-label="Service" class="table-service">5375 — TikTok Followers [Refill: No] [Cheapest]</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">0</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">6291815</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-03-31</span>
                                            <span class="nowrap">01:36:42</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=https%3A%2F%2Fvt.tiktok.com%2FZSHLNuoKg%2F" target="_blank">https://vt.tiktok.com/ZSHLNuoKg/</a>
                                                                                    </td>
                                        <td data-label="Charge">0.0315</td>
                                        <td data-label="Start count" class="nowrap">250</td>
                                        <td data-label="Quantity">3000</td>
                                        <td data-label="Service" class="table-service">5797 — TikTok Video Views [Non Drop] [Refill: No] [Instant Start] 10M/Day</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">0</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">6288229</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-03-30</span>
                                            <span class="nowrap">23:16:25</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=https%3A%2F%2Fwww.tiktok.com%2F%40qunh.oanh888%3F_r%3D1%26amp%3B_t%3DZS-958mzmgnsvA" target="_blank">https://www.tiktok.com/@qunh.oanh888?_r=1&amp;_t=ZS-958mzmgnsvA</a>
                                                                                    </td>
                                        <td data-label="Charge">1.449</td>
                                        <td data-label="Start count" class="nowrap">467</td>
                                        <td data-label="Quantity">1000</td>
                                        <td data-label="Service" class="table-service">5375 — TikTok Followers [Refill: No] [Cheapest]</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">0</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">6266059</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-03-30</span>
                                            <span class="nowrap">09:01:52</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=https%3A%2F%2Fwww.tiktok.com%2F%40svhok.z.games123%2Fvideo%2F7614188323002731796%3Fis_from_webapp%3D1%26amp%3Bsender_device%3Dpc%26amp%3Bweb_id%3D7475012624834201143" target="_blank">https://www.tiktok.com/@svhok.z.games123/video/7614188323002731796?is_from_webapp=1&amp;sender_device=pc&amp;web_id=7475012624834201143</a>
                                                                                    </td>
                                        <td data-label="Charge">0.0105</td>
                                        <td data-label="Start count" class="nowrap">359</td>
                                        <td data-label="Quantity">1000</td>
                                        <td data-label="Service" class="table-service">5797 — TikTok Video Views [Non Drop] [Refill: No] [Instant Start] 10M/Day</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">0</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">6186683</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-03-28</span>
                                            <span class="nowrap">07:22:54</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=https%3A%2F%2Fwww.tiktok.com%2F%40tudo5831" target="_blank">https://www.tiktok.com/@tudo5831</a>
                                                                                    </td>
                                        <td data-label="Charge">0.1449</td>
                                        <td data-label="Start count" class="nowrap">232</td>
                                        <td data-label="Quantity">100</td>
                                        <td data-label="Service" class="table-service">5375 — TikTok Followers [Refill: No] [Cheapest]</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">+4</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">6185736</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-03-28</span>
                                            <span class="nowrap">06:45:44</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=https%3A%2F%2Fwww.tiktok.com%2F%40hailam.haydi%2Fvideo%2F7615485461221346580" target="_blank">https://www.tiktok.com/@hailam.haydi/video/7615485461221346580</a>
                                                                                    </td>
                                        <td data-label="Charge">0.1575</td>
                                        <td data-label="Start count" class="nowrap">39121</td>
                                        <td data-label="Quantity">15000</td>
                                        <td data-label="Service" class="table-service">5797 — TikTok Video Views [Non Drop] [Refill: No] [Instant Start] 10M/Day</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">0</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">6185378</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-03-28</span>
                                            <span class="nowrap">06:31:32</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=https%3A%2F%2Fvt.tiktok.com%2FZSHJcMbKc%2F" target="_blank">https://vt.tiktok.com/ZSHJcMbKc/</a>
                                                                                    </td>
                                        <td data-label="Charge">0.3675</td>
                                        <td data-label="Start count" class="nowrap">2781</td>
                                        <td data-label="Quantity">35000</td>
                                        <td data-label="Service" class="table-service">5797 — TikTok Video Views [Non Drop] [Refill: No] [Instant Start] 10M/Day</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">0</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">6185327</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-03-28</span>
                                            <span class="nowrap">06:29:28</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=https%3A%2F%2Fwww.tiktok.com%2F%40hailam.haydi%2Fvideo%2F7621048518492376340" target="_blank">https://www.tiktok.com/@hailam.haydi/video/7621048518492376340</a>
                                                                                    </td>
                                        <td data-label="Charge">0.21</td>
                                        <td data-label="Start count" class="nowrap">49938</td>
                                        <td data-label="Quantity">20000</td>
                                        <td data-label="Service" class="table-service">5797 — TikTok Video Views [Non Drop] [Refill: No] [Instant Start] 10M/Day</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">0</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">6185312</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-03-28</span>
                                            <span class="nowrap">06:28:46</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=https%3A%2F%2Fwww.tiktok.com%2F%40hailam.haydi%2Fvideo%2F7615485461221346580" target="_blank">https://www.tiktok.com/@hailam.haydi/video/7615485461221346580</a>
                                                                                    </td>
                                        <td data-label="Charge">0.105</td>
                                        <td data-label="Start count" class="nowrap">29060</td>
                                        <td data-label="Quantity">10000</td>
                                        <td data-label="Service" class="table-service">5797 — TikTok Video Views [Non Drop] [Refill: No] [Instant Start] 10M/Day</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">0</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">6155932</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-03-27</span>
                                            <span class="nowrap">10:19:41</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=https%3A%2F%2Fwww.tiktok.com%2F%40duyminh.duyminh3%3F_r%3D1%26amp%3B_t%3DZS-94xjSw2vlqe" target="_blank">https://www.tiktok.com/@duyminh.duyminh3?_r=1&amp;_t=ZS-94xjSw2vlqe</a>
                                                                                    </td>
                                        <td data-label="Charge">0.07245</td>
                                        <td data-label="Start count" class="nowrap">903</td>
                                        <td data-label="Quantity">50</td>
                                        <td data-label="Service" class="table-service">5375 — TikTok Followers [Refill: No] [Cheapest]</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">0</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">6149643</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-03-27</span>
                                            <span class="nowrap">06:45:39</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=https%3A%2F%2Fvt.tiktok.com%2FZSuo9NoNo%2F" target="_blank">https://vt.tiktok.com/ZSuo9NoNo/</a>
                                                                                    </td>
                                        <td data-label="Charge">0.0105</td>
                                        <td data-label="Start count" class="nowrap">135</td>
                                        <td data-label="Quantity">1000</td>
                                        <td data-label="Service" class="table-service">5797 — TikTok Video Views [Non Drop] [Refill: No] [Instant Start] 10M/Day</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">0</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">6147871</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-03-27</span>
                                            <span class="nowrap">05:52:55</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=nttthanh376" target="_blank">nttthanh376</a>
                                                                                    </td>
                                        <td data-label="Charge">0.21735</td>
                                        <td data-label="Start count" class="nowrap">890</td>
                                        <td data-label="Quantity">150</td>
                                        <td data-label="Service" class="table-service">5375 — TikTok Followers [Refill: No] [Cheapest]</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">+3</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">6140944</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-03-27</span>
                                            <span class="nowrap">02:08:32</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=https%3A%2F%2Fwww.tiktok.com%2F%40haodn797979%3F_d%3DsecCgYIASAHKAESPgo84pbvr30M44R2ShDWR7PRo4XkwR0ij%252FtZBWBbzTHFVvIeC8oRiZbStcw45fLCfTJ%252BlABWpIWuqeOkPRXfGgA%253D%26amp%3B_r%3D1%26amp%3Bobject_id%3D7617520502350234642%26amp%3Bpage_open_method%3Dscan_code%26amp%3Bschema_type%3D4%26amp%3Bsec_uid%3DMS4wLjABAAAAVBK4K5Wg8eGfUsrz7yPFjw7NLUCkDB-5HHwWcer87h5qVhNq1wJXCKYdm-6uaYKx%26amp%3Bshare_app_id%3D1180%26amp%3Bshare_author_id%3D7617520502350234642%26amp%3Bshare_uid%3D7617520502350234642%26amp%3Btt_from%3Dscan_code%26amp%3Butm_campaign%3Dclient_scan_code%26amp%3Butm_medium%3D1%26amp%3Butm_source%3Dscan_code" target="_blank">https://www.tiktok.com/@haodn797979?_d=secCgYIASAHKAESPgo84pbvr30M44R2ShDWR7PRo4XkwR0ij%2FtZBWBbzTHFVvIeC8oRiZbStcw45fLCfTJ%2BlABWpIWuqeOkPRXfGgA%3D&amp;_r=1&amp;object_id=7617520502350234642&amp;page_open_method=scan_code&amp;schema_type=4&amp;sec_uid=MS4wLjABAAAAVBK4K5Wg8eGfUsrz7yPFjw7NLUCkDB-5HHwWcer87h5qVhNq1wJXCKYdm-6uaYKx&amp;share_app_id=1180&amp;share_author_id=7617520502350234642&amp;share_uid=7617520502350234642&amp;tt_from=scan_code&amp;utm_campaign=client_scan_code&amp;utm_medium=1&amp;utm_source=scan_code</a>
                                                                                    </td>
                                        <td data-label="Charge">0.1449</td>
                                        <td data-label="Start count" class="nowrap">990</td>
                                        <td data-label="Quantity">100</td>
                                        <td data-label="Service" class="table-service">5375 — TikTok Followers [Refill: No] [Cheapest]</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">0</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">6133443</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-03-26</span>
                                            <span class="nowrap">20:47:11</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=https%3A%2F%2Fwww.tiktok.com%2F%40_lnhtr.iuu%3F_r%3D1%26amp%3B_t%3DZS-94t5eD4zTgz" target="_blank">https://www.tiktok.com/@_lnhtr.iuu?_r=1&amp;_t=ZS-94t5eD4zTgz</a>
                                                                                    </td>
                                        <td data-label="Charge">0.02898</td>
                                        <td data-label="Start count" class="nowrap">922</td>
                                        <td data-label="Quantity">20</td>
                                        <td data-label="Service" class="table-service">5375 — TikTok Followers [Refill: No] [Cheapest]</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">0</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">6131986</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-03-26</span>
                                            <span class="nowrap">18:40:51</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=https%3A%2F%2Fvt.tiktok.com%2FZSuEFf4Jv%2F" target="_blank">https://vt.tiktok.com/ZSuEFf4Jv/</a>
                                                                                    </td>
                                        <td data-label="Charge">0.0021</td>
                                        <td data-label="Start count" class="nowrap">523</td>
                                        <td data-label="Quantity">200</td>
                                        <td data-label="Service" class="table-service">5797 — TikTok Video Views [Non Drop] [Refill: No] [Instant Start] 10M/Day</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">0</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">6117884</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-03-26</span>
                                            <span class="nowrap">11:16:04</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=https%3A%2F%2Fwww.tiktok.com%2F%40nttthanh376%3F_r%3D1%26amp%3B_t%3DZS-94veXxKOWc0" target="_blank">https://www.tiktok.com/@nttthanh376?_r=1&amp;_t=ZS-94veXxKOWc0</a>
                                                                                    </td>
                                        <td data-label="Charge">0.1449</td>
                                        <td data-label="Start count" class="nowrap">878</td>
                                        <td data-label="Quantity">100</td>
                                        <td data-label="Service" class="table-service">5375 — TikTok Followers [Refill: No] [Cheapest]</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">0</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">6117559</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-03-26</span>
                                            <span class="nowrap">11:06:42</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=https%3A%2F%2Fwww.tiktok.com%2F%40yarsa.vyt" target="_blank">https://www.tiktok.com/@yarsa.vyt</a>
                                                                                    </td>
                                        <td data-label="Charge">0.05796</td>
                                        <td data-label="Start count" class="nowrap">1285</td>
                                        <td data-label="Quantity">40</td>
                                        <td data-label="Service" class="table-service">5375 — TikTok Followers [Refill: No] [Cheapest]</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">0</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">6115652</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-03-26</span>
                                            <span class="nowrap">10:09:14</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=https%3A%2F%2Fvt.tiktok.com%2FZSuKa5dbx%2F" target="_blank">https://vt.tiktok.com/ZSuKa5dbx/</a>
                                                                                    </td>
                                        <td data-label="Charge">0.21</td>
                                        <td data-label="Start count" class="nowrap">583</td>
                                        <td data-label="Quantity">20000</td>
                                        <td data-label="Service" class="table-service">5797 — TikTok Video Views [Non Drop] [Refill: No] [Instant Start] 10M/Day</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">0</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">6084095</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-03-25</span>
                                            <span class="nowrap">15:26:17</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=https%3A%2F%2Fwww.tiktok.com%2F%40diamonddatdat%3F_r%3D1%26amp%3B_t%3DZS-94sc8lemWUn" target="_blank">https://www.tiktok.com/@diamonddatdat?_r=1&amp;_t=ZS-94sc8lemWUn</a>
                                                                                    </td>
                                        <td data-label="Charge">0.13041</td>
                                        <td data-label="Start count" class="nowrap">1629</td>
                                        <td data-label="Quantity">90</td>
                                        <td data-label="Service" class="table-service">5375 — TikTok Followers [Refill: No] [Cheapest]</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">0</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">6083320</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-03-25</span>
                                            <span class="nowrap">15:02:20</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=https%3A%2F%2Fwww.tiktok.com%2F%40n.huyen_99" target="_blank">https://www.tiktok.com/@n.huyen_99</a>
                                                                                    </td>
                                        <td data-label="Charge">0.2898</td>
                                        <td data-label="Start count" class="nowrap">1597</td>
                                        <td data-label="Quantity">200</td>
                                        <td data-label="Service" class="table-service">5375 — TikTok Followers [Refill: No] [Cheapest]</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">0</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">6083244</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-03-25</span>
                                            <span class="nowrap">14:59:34</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=https%3A%2F%2Fwww.tiktok.com%2F%40embetapreview2006%3F_r%3D1%26amp%3B_t%3DZS-94lhSJNKwwn" target="_blank">https://www.tiktok.com/@embetapreview2006?_r=1&amp;_t=ZS-94lhSJNKwwn</a>
                                                                                    </td>
                                        <td data-label="Charge">0.13041</td>
                                        <td data-label="Start count" class="nowrap">861</td>
                                        <td data-label="Quantity">90</td>
                                        <td data-label="Service" class="table-service">5375 — TikTok Followers [Refill: No] [Cheapest]</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">0</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">6081320</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-03-25</span>
                                            <span class="nowrap">14:00:30</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=tuyenloto3" target="_blank">tuyenloto3</a>
                                                                                    </td>
                                        <td data-label="Charge">0.01449</td>
                                        <td data-label="Start count" class="nowrap">4362</td>
                                        <td data-label="Quantity">10</td>
                                        <td data-label="Service" class="table-service">5375 — TikTok Followers [Refill: No] [Cheapest]</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">0</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">6025102</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-03-24</span>
                                            <span class="nowrap">07:19:45</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=https%3A%2F%2Fwww.tiktok.com%2F%40duyhopham5%2Fvideo%2F7507975253595933970" target="_blank">https://www.tiktok.com/@duyhopham5/video/7507975253595933970</a>
                                                                                    </td>
                                        <td data-label="Charge">0.00105</td>
                                        <td data-label="Start count" class="nowrap">2213</td>
                                        <td data-label="Quantity">100</td>
                                        <td data-label="Service" class="table-service">5797 — TikTok Video Views [Non Drop] [Refill: No] [Instant Start] 10M/Day</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">0</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">6024804</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-03-24</span>
                                            <span class="nowrap">07:10:31</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=https%3A%2F%2Fwww.tiktok.com%2F%40duyhopham5%2Fvideo%2F7507975253595933970" target="_blank">https://www.tiktok.com/@duyhopham5/video/7507975253595933970</a>
                                                                                    </td>
                                        <td data-label="Charge">0.00105</td>
                                        <td data-label="Start count" class="nowrap">2858</td>
                                        <td data-label="Quantity">100</td>
                                        <td data-label="Service" class="table-service">5797 — TikTok Video Views [Non Drop] [Refill: No] [Instant Start] 10M/Day</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">0</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">6024803</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-03-24</span>
                                            <span class="nowrap">07:10:30</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=https%3A%2F%2Fwww.tiktok.com%2F%40duyhopham5%2Fvideo%2F7507975253595933970" target="_blank">https://www.tiktok.com/@duyhopham5/video/7507975253595933970</a>
                                                                                    </td>
                                        <td data-label="Charge">0.00105</td>
                                        <td data-label="Start count" class="nowrap">2746</td>
                                        <td data-label="Quantity">100</td>
                                        <td data-label="Service" class="table-service">5797 — TikTok Video Views [Non Drop] [Refill: No] [Instant Start] 10M/Day</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">0</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">6024802</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-03-24</span>
                                            <span class="nowrap">07:10:28</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=https%3A%2F%2Fwww.tiktok.com%2F%40duyhopham5%2Fvideo%2F7507975253595933970" target="_blank">https://www.tiktok.com/@duyhopham5/video/7507975253595933970</a>
                                                                                    </td>
                                        <td data-label="Charge">0.00105</td>
                                        <td data-label="Start count" class="nowrap">2634</td>
                                        <td data-label="Quantity">100</td>
                                        <td data-label="Service" class="table-service">5797 — TikTok Video Views [Non Drop] [Refill: No] [Instant Start] 10M/Day</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">0</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">6024801</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-03-24</span>
                                            <span class="nowrap">07:10:27</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=https%3A%2F%2Fwww.tiktok.com%2F%40duyhopham5%2Fvideo%2F7507975253595933970" target="_blank">https://www.tiktok.com/@duyhopham5/video/7507975253595933970</a>
                                                                                    </td>
                                        <td data-label="Charge">0.00105</td>
                                        <td data-label="Start count" class="nowrap">2529</td>
                                        <td data-label="Quantity">100</td>
                                        <td data-label="Service" class="table-service">5797 — TikTok Video Views [Non Drop] [Refill: No] [Instant Start] 10M/Day</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">0</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">6024800</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-03-24</span>
                                            <span class="nowrap">07:10:25</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=https%3A%2F%2Fwww.tiktok.com%2F%40duyhopham5%2Fvideo%2F7507975253595933970" target="_blank">https://www.tiktok.com/@duyhopham5/video/7507975253595933970</a>
                                                                                    </td>
                                        <td data-label="Charge">0.00105</td>
                                        <td data-label="Start count" class="nowrap">2424</td>
                                        <td data-label="Quantity">100</td>
                                        <td data-label="Service" class="table-service">5797 — TikTok Video Views [Non Drop] [Refill: No] [Instant Start] 10M/Day</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">0</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">6024790</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-03-24</span>
                                            <span class="nowrap">07:10:10</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=https%3A%2F%2Fwww.tiktok.com%2F%40duyhopham5%2Fvideo%2F7507975253595933970" target="_blank">https://www.tiktok.com/@duyhopham5/video/7507975253595933970</a>
                                                                                    </td>
                                        <td data-label="Charge">0.00105</td>
                                        <td data-label="Start count" class="nowrap">2321</td>
                                        <td data-label="Quantity">100</td>
                                        <td data-label="Service" class="table-service">5797 — TikTok Video Views [Non Drop] [Refill: No] [Instant Start] 10M/Day</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">0</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">6024787</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-03-24</span>
                                            <span class="nowrap">07:10:06</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=https%3A%2F%2Fwww.tiktok.com%2F%40duyhopham5%2Fvideo%2F7507975253595933970" target="_blank">https://www.tiktok.com/@duyhopham5/video/7507975253595933970</a>
                                                                                    </td>
                                        <td data-label="Charge">0.00105</td>
                                        <td data-label="Start count" class="nowrap">2103</td>
                                        <td data-label="Quantity">100</td>
                                        <td data-label="Service" class="table-service">5797 — TikTok Video Views [Non Drop] [Refill: No] [Instant Start] 10M/Day</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">0</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">6015899</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-03-24</span>
                                            <span class="nowrap">02:45:37</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=https%3A%2F%2Fvt.tiktok.com%2FZSuvJ7cX5%2F" target="_blank">https://vt.tiktok.com/ZSuvJ7cX5/</a>
                                                                                    </td>
                                        <td data-label="Charge">0.0525</td>
                                        <td data-label="Start count" class="nowrap">69</td>
                                        <td data-label="Quantity">5000</td>
                                        <td data-label="Service" class="table-service">5797 — TikTok Video Views [Non Drop] [Refill: No] [Instant Start] 10M/Day</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">0</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">6015612</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-03-24</span>
                                            <span class="nowrap">02:37:39</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=duyhopham5" target="_blank">duyhopham5</a>
                                                                                    </td>
                                        <td data-label="Charge">0.1449</td>
                                        <td data-label="Start count" class="nowrap">12159</td>
                                        <td data-label="Quantity">100</td>
                                        <td data-label="Service" class="table-service">5375 — TikTok Followers [Refill: No] [Cheapest]</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">0</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">6009934</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-03-23</span>
                                            <span class="nowrap">22:48:34</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=https%3A%2F%2Fwww.tiktok.com%2F%40duyhopham5%2Fvideo%2F7507975253595933970" target="_blank">https://www.tiktok.com/@duyhopham5/video/7507975253595933970</a>
                                                                                    </td>
                                        <td data-label="Charge">0.0105</td>
                                        <td data-label="Start count" class="nowrap">1081</td>
                                        <td data-label="Quantity">1000</td>
                                        <td data-label="Service" class="table-service">5797 — TikTok Video Views [Non Drop] [Refill: No] [Instant Start] 10M/Day</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">0</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">6008158</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-03-23</span>
                                            <span class="nowrap">20:57:06</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=https%3A%2F%2Fvt.tiktok.com%2FZSu7Pk7tw%2F" target="_blank">https://vt.tiktok.com/ZSu7Pk7tw/</a>
                                                                                    </td>
                                        <td data-label="Charge">0.0315</td>
                                        <td data-label="Start count" class="nowrap">302</td>
                                        <td data-label="Quantity">3000</td>
                                        <td data-label="Service" class="table-service">5797 — TikTok Video Views [Non Drop] [Refill: No] [Instant Start] 10M/Day</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">0</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">6008152</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-03-23</span>
                                            <span class="nowrap">20:56:54</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=https%3A%2F%2Fvt.tiktok.com%2FZSu7P8Mbp%2F" target="_blank">https://vt.tiktok.com/ZSu7P8Mbp/</a>
                                                                                    </td>
                                        <td data-label="Charge">0.0315</td>
                                        <td data-label="Start count" class="nowrap">286</td>
                                        <td data-label="Quantity">3000</td>
                                        <td data-label="Service" class="table-service">5797 — TikTok Video Views [Non Drop] [Refill: No] [Instant Start] 10M/Day</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">0</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">6007842</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-03-23</span>
                                            <span class="nowrap">20:38:19</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=https%3A%2F%2Fvt.tiktok.com%2FZSu7UGBcC%2F" target="_blank">https://vt.tiktok.com/ZSu7UGBcC/</a>
                                                                                    </td>
                                        <td data-label="Charge">0.105</td>
                                        <td data-label="Start count" class="nowrap">222</td>
                                        <td data-label="Quantity">10000</td>
                                        <td data-label="Service" class="table-service">5797 — TikTok Video Views [Non Drop] [Refill: No] [Instant Start] 10M/Day</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">0</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">6004238</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-03-23</span>
                                            <span class="nowrap">17:33:05</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=https%3A%2F%2Fvt.tiktok.com%2FZSu7d5CdA%2F" target="_blank">https://vt.tiktok.com/ZSu7d5CdA/</a>
                                                                                    </td>
                                        <td data-label="Charge">0.01575</td>
                                        <td data-label="Start count" class="nowrap">272</td>
                                        <td data-label="Quantity">1500</td>
                                        <td data-label="Service" class="table-service">5797 — TikTok Video Views [Non Drop] [Refill: No] [Instant Start] 10M/Day</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">0</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">5984433</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-03-23</span>
                                            <span class="nowrap">08:10:21</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=https%3A%2F%2Fvt.tiktok.com%2FZSuWAdxSM%2F" target="_blank">https://vt.tiktok.com/ZSuWAdxSM/</a>
                                                                                    </td>
                                        <td data-label="Charge">0.105</td>
                                        <td data-label="Start count" class="nowrap">1781</td>
                                        <td data-label="Quantity">10000</td>
                                        <td data-label="Service" class="table-service">5797 — TikTok Video Views [Non Drop] [Refill: No] [Instant Start] 10M/Day</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">0</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">5984083</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-03-23</span>
                                            <span class="nowrap">08:01:32</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=https%3A%2F%2Fvt.tiktok.com%2FZSuWSejE7%2F" target="_blank">https://vt.tiktok.com/ZSuWSejE7/</a>
                                                                                    </td>
                                        <td data-label="Charge">0.0525</td>
                                        <td data-label="Start count" class="nowrap">54</td>
                                        <td data-label="Quantity">5000</td>
                                        <td data-label="Service" class="table-service">5797 — TikTok Video Views [Non Drop] [Refill: No] [Instant Start] 10M/Day</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">0</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">5982194</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-03-23</span>
                                            <span class="nowrap">07:14:19</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=https%3A%2F%2Fvt.tiktok.com%2FZSuWr84Q4%2F" target="_blank">https://vt.tiktok.com/ZSuWr84Q4/</a>
                                                                                    </td>
                                        <td data-label="Charge">0.0525</td>
                                        <td data-label="Start count" class="nowrap">64</td>
                                        <td data-label="Quantity">5000</td>
                                        <td data-label="Service" class="table-service">5797 — TikTok Video Views [Non Drop] [Refill: No] [Instant Start] 10M/Day</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">0</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">5981224</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-03-23</span>
                                            <span class="nowrap">06:40:45</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=https%3A%2F%2Fwww.tiktok.com%2F%40hvan.o9_%2Fphoto%2F7619908408904289543%3Fis_from_webapp%3D1%26amp%3Bsender_device%3Dpc" target="_blank">https://www.tiktok.com/@hvan.o9_/photo/7619908408904289543?is_from_webapp=1&amp;sender_device=pc</a>
                                                                                    </td>
                                        <td data-label="Charge">0.0105</td>
                                        <td data-label="Start count" class="nowrap">12332</td>
                                        <td data-label="Quantity">1000</td>
                                        <td data-label="Service" class="table-service">5797 — TikTok Video Views [Non Drop] [Refill: No] [Instant Start] 10M/Day</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">0</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">5981073</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-03-23</span>
                                            <span class="nowrap">06:35:21</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=https%3A%2F%2Fvt.tiktok.com%2FZSuW8Ghgg%2F" target="_blank">https://vt.tiktok.com/ZSuW8Ghgg/</a>
                                                                                    </td>
                                        <td data-label="Charge">0.0105</td>
                                        <td data-label="Start count" class="nowrap">1129</td>
                                        <td data-label="Quantity">1000</td>
                                        <td data-label="Service" class="table-service">5797 — TikTok Video Views [Non Drop] [Refill: No] [Instant Start] 10M/Day</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">0</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">5981065</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-03-23</span>
                                            <span class="nowrap">06:34:58</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=https%3A%2F%2Fvt.tiktok.com%2FZSuWFuD2C%2F" target="_blank">https://vt.tiktok.com/ZSuWFuD2C/</a>
                                                                                    </td>
                                        <td data-label="Charge">0.105</td>
                                        <td data-label="Start count" class="nowrap">69</td>
                                        <td data-label="Quantity">10000</td>
                                        <td data-label="Service" class="table-service">5797 — TikTok Video Views [Non Drop] [Refill: No] [Instant Start] 10M/Day</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">0</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">5981005</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-03-23</span>
                                            <span class="nowrap">06:32:36</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=https%3A%2F%2Fvt.tiktok.com%2FZSuW8Ghgg%2F" target="_blank">https://vt.tiktok.com/ZSuW8Ghgg/</a>
                                                                                    </td>
                                        <td data-label="Charge">0.0105</td>
                                        <td data-label="Start count" class="nowrap">75</td>
                                        <td data-label="Quantity">1000</td>
                                        <td data-label="Service" class="table-service">5797 — TikTok Video Views [Non Drop] [Refill: No] [Instant Start] 10M/Day</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">0</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">5978069</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-03-23</span>
                                            <span class="nowrap">04:59:08</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=https%3A%2F%2Fvt.tiktok.com%2FZSuWJyeBY%2F" target="_blank">https://vt.tiktok.com/ZSuWJyeBY/</a>
                                                                                    </td>
                                        <td data-label="Charge">0.0105</td>
                                        <td data-label="Start count" class="nowrap">76</td>
                                        <td data-label="Quantity">1000</td>
                                        <td data-label="Service" class="table-service">5797 — TikTok Video Views [Non Drop] [Refill: No] [Instant Start] 10M/Day</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">0</td>
                                                                            </tr>
                                                                    <tr>
                                        <td data-label="ID">5969270</td>
                                        <td data-label="Date">
                                                                                        <span class="nowrap">2026-03-23</span>
                                            <span class="nowrap">00:22:36</span>
                                        </td>
                                        <td data-label="Link" class="table-link">
                                            <a href="/anon.ws?r=https%3A%2F%2Fvt.tiktok.com%2FZSupfJDHm%2F" target="_blank">https://vt.tiktok.com/ZSupfJDHm/</a>
                                                                                    </td>
                                        <td data-label="Charge">0.0315</td>
                                        <td data-label="Start count" class="nowrap">78</td>
                                        <td data-label="Quantity">3000</td>
                                        <td data-label="Service" class="table-service">5797 — TikTok Video Views [Non Drop] [Refill: No] [Instant Start] 10M/Day</td>
                                        <td data-label="Status" nowrap="">
                                            Completed                                        </td>
                                        <td data-label="Remains">0</td>
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
</div></div></div>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.order-action-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const href = this.dataset.href;
                const td = this.closest('td');
                this.disabled = true;
                this.style.opacity = '0.6';

                fetch(href)
                    .then(r => r.json())
                    .then(data => {
                        if (data.status === 'success') {
                            td.innerHTML =
                                `<span class="orders-history-actions-text">${data.btn_text}</span>`;
                        } else {
                            showOrderError(data.message || 'An error occurred');
                            this.disabled = false;
                            this.style.opacity = '1';
                        }
                    })
                    .catch(() => {
                        showOrderError('An error occurred while processing your request');
                        this.disabled = false;
                        this.style.opacity = '1';
                    });
            });
        });

        function showOrderError(message) {
            const el = document.getElementById('js-order-alert-error');
            if (!el) return;
            el.querySelector('.text').innerHTML = message;
            el.style.display = 'block';
            el.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        }

        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.close[data-hide="alert"]');
            if (btn) {
                const al = btn.closest('.alert');
                if (al) al.style.display = 'none';
            }
        });
    </script>
@endpush
