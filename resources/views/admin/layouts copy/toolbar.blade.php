<div class="toolbar py-3 py-lg-6" id="kt_toolbar">
   <!--begin::Container-->
   <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap gap-2">
      <!--begin::Page title-->
      <div class="page-title d-flex flex-column align-items-start me-3 py-2 py-lg-0 gap-2">
         <!--begin::Title-->
         <h1 class="d-flex text-gray-900 fw-bold m-0 fs-3" data-lang="menu::Orders">Đơn hàng</h1>
         <!--end::Title-->
         <!--begin::Breadcrumb-->
         <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7">
            <!--begin::Item-->
            <li class="breadcrumb-item text-gray-600" data-lang="menu::Orders">Đơn hàng</li>
         </ul>
         <!--end::Breadcrumb-->
      </div>
      <!--end::Page title-->
      <!--begin::Actions-->
      <div class="d-flex align-items-center">
         <!--begin::Button-->
         <button type="button" id="toggleNotes" class="btn btn-icon btn-color-warning bg-body w-35px h-35px w-lg-40px h-lg-40px me-3 btn-open-note">
         <i class="ki-duotone ki-document fs-2 fs-md-1">
         <span class="path1"></span>
         <span class="path2"></span>
         </i>
         </button>
         <!--end::Button-->
         <!--begin::Daterange-->
         <a href="javascript:;" class="btn bg-body px-5 text-muted fw-semibold">{{ now()->timezone('Asia/Ho_Chi_Minh')->format('Y/m/d') }} (+07:00)</a>
         <!--end::Daterange-->
      </div>
      <!--end::Actions-->
   </div>
   <!--end::Container-->
</div>
