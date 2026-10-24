<ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold mt-4">
    <li class="nav-item"><a class="nav-link ms-0 me-6 {{ $activeTab === 'payment' ? 'active' : '' }}" href="{{ route('admin.accounts.payment', $accounts->username) }}" data-lang="Payment">Payment</a></li>
    <li class="nav-item"><a class="nav-link ms-0 me-6 {{ $activeTab === 'customrates' ? 'active' : '' }}" href="{{ route('admin.accounts.customrates', $accounts->username) }}" data-lang="Custom rates">Custom rates</a></li>
    <li class="nav-item"><a class="nav-link ms-0 me-6 {{ $activeTab === 'signinhistory' ? 'active' : '' }}" href="{{ route('admin.accounts.signinhistory', $accounts->username) }}" data-lang="Sign-in history">Sign-in history</a></li>
    <li class="nav-item"><a class="nav-link ms-0 me-6 {{ $activeTab === 'transactions' ? 'active' : '' }}" href="{{ route('admin.accounts.transactions', $accounts->username) }}" data-lang="Transactions">Transactions</a></li>
    <li class="nav-item"><a class="nav-link ms-0 me-6 {{ $activeTab === 'affiliates' ? 'active' : '' }}" href="{{ route('admin.accounts.affiliates', $accounts->username) }}" data-lang="Affiliates">Affiliates</a></li>
</ul>
