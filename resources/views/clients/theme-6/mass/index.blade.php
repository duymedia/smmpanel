@extends('clients.theme-6.layouts.app')

@section('title', __('massOrder.title'))

@section('content')
    <div id="block_114">
        <div class="block-bg"></div>
        <div class="container">
            <div class="new_order-block">
                <div class="row mass-order__alignment">
                    <div class="col-lg-12">
                        <div class="component_card">
                            <div class="card">
                                <div id="alertSection" style="display:none; margin-bottom:20px;"></div>

                                <form id="massOrderForm">
                                    <div class="component_form_group">
                                        <div class="">
                                            <div class="form-group">
                                                <label for="links" class="control-label">{{ __('massOrder.format_example') }}</label>
                                                <textarea class="form-control" name="orders" rows="15" id="links"
                                                    placeholder="{{ __('massOrder.format_placeholder') }}"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="component_button_submit">
                                        <div class="">
                                            <button type="submit" class="btn btn-block btn-big-primary" id="submitBtn">
                                                {{ __('massOrder.submit') }}
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
    </div>
@endsection

@push('scripts')
<script>
document.getElementById('massOrderForm').addEventListener('submit', async function (e) {
    e.preventDefault();

    const textarea   = document.getElementById('links');
    const lines      = textarea.value.trim().split('\n').filter(l => l.trim());
    const alertSection = document.getElementById('alertSection');
    const submitBtn  = document.getElementById('submitBtn');

    if (!lines.length) {
        alert('{{ __('massOrder.please_enter_order') }}');
        return;
    }

    alertSection.style.display = 'none';
    alertSection.innerHTML = '';
    submitBtn.disabled = true;

    let successCount = 0;
    let errorCount   = 0;
    const orderIds   = [];
    const csrfToken  = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

    for (const line of lines) {
        const parts = line.trim().split('|').map(p => p.trim());

        if (parts.length !== 3) { errorCount++; continue; }

        const [serviceId, link, quantity] = parts;

        if (!serviceId || !link || !quantity || isNaN(quantity) || parseInt(quantity) <= 0) {
            errorCount++;
            continue;
        }

        try {
            const res  = await fetch('{{ route('clients.orders.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    service:  parseInt(serviceId),
                    link:     link,
                    quantity: parseInt(quantity)
                })
            });
            const data = await res.json();
            if (data.success) {
                successCount++;
                if (data.order_id) orderIds.push(data.order_id);
            } else {
                errorCount++;
            }
        } catch {
            errorCount++;
        }

        await new Promise(r => setTimeout(r, 300));
    }

    const total       = successCount + errorCount;
    const detailsLink = orderIds.length ? `/orders?ids=${orderIds.join(',')}` : '#';
    const type        = errorCount > 0 ? 'danger' : 'success';
    const title       = errorCount > 0 ? '{{ __('massOrder.failed') }}' : '{{ __('massOrder.success') ?? 'Success' }}';

    alertSection.innerHTML = `
        <div class="alert alert-dismissible alert-${type}">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <h4>${title}</h4>
            {{ __('massOrder.total_orders') }}: ${total}<br>
            {{ __('massOrder.total_errors') }}: ${errorCount}<br>
            <a href="${detailsLink}" target="_blank">{{ __('massOrder.details') }}</a>
        </div>`;
    alertSection.style.display = 'block';
    alertSection.scrollIntoView({ behavior: 'smooth', block: 'center' });

    submitBtn.disabled = false;
});
</script>
@endpush
