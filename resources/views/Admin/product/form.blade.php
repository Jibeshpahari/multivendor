@extends('admin.layout.app')

@section('content')
    <div class="row g-3">
        <div class="col-8">
            <div id="col8SortArea">
                <div class="sortable-card" data-card-id="product-details">
                    <div class="card-move-wrap" data-move-wrap>
                        <button type="button" class="card-move-btn" data-move="up" title="Move up" aria-label="Move card up">
                            <i class="fa-solid fa-caret-up" aria-hidden="true"></i>
                        </button>
                        <button type="button" class="card-move-btn" data-move="down" title="Move down"
                            aria-label="Move card down">
                            <i class="fa-solid fa-caret-down" aria-hidden="true"></i>
                        </button>
                    </div>
                    <div class="card p-4 mb-3">
                        <p class="fs-6 fw-semibold">Product Details</p>
                        <div class="row">
                            <div class="form-group col-12">
                                <label for="name" class="form-label"> Product Name </label>
                                <input type="text" class="form-control" name="name" value="{{ '' }}"
                                    id="name" placeholder="Enter product name">
                                @error('name')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-12">
                                <label for="description" class="form-label"> Description </label>
                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                @error('description')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-6">
                                <label class="field-label text-ink-3" for="priceInput">Price</label>
                                <div class="input-group">
                                    <span class="input-group-text" aria-hidden="true">$</span>
                                    <input type="number" name="priceInput" id="priceInput" class="form-control"
                                        min="0" step="0.01" value="1200.00" inputmode="decimal">
                                </div>
                            </div>

                            <div class="form-group col-6">
                                <label class="field-label text-ink-3" for="compareAtInput">Compare at</label>
                                <div class="input-group">
                                    <span class="input-group-text" aria-hidden="true">$</span>
                                    <input type="number" name="compareAtInput" id="compareAtInput" class="form-control"
                                        min="0" step="0.01" value="1200.00" inputmode="decimal">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-check ps-0">
                                    <input class="form-check-input check-black" type="checkbox" id="chargeTax"
                                        name="chargeTax" checked>
                                    <label class="form-check-label" for="chargeTax">Charge tax for this product</label>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="sortable-card" data-card-id="variants-trigger">
                    <div class="variants-trigger-card">
                        <button type="button" class="variants-trigger-btn" data-bs-toggle="offcanvas"
                            data-bs-target="#variantsModal" aria-controls="variantsModal">
                            <span class="variants-trigger-icon"><i class="fa-solid fa-layer-group"
                                    aria-hidden="true"></i></span>
                            <span class="variants-trigger-text">
                                <span class="d-block fw-semibold">Variants</span>
                                <span class="d-block small text-muted">Manage variant types and combinations</span>
                            </span>
                            <span class="variants-trigger-arrow"><i class="fa-solid fa-chevron-right"
                                    aria-hidden="true"></i></span>
                        </button>
                        <div class="card-move-wrap card-move-wrap--inline">
                            <button type="button" class="card-move-btn" data-move="up" title="Move up"
                                aria-label="Move card up">
                                <i class="fa-solid fa-caret-up" aria-hidden="true"></i>
                            </button>
                            <button type="button" class="card-move-btn" data-move="down" title="Move down"
                                aria-label="Move card down">
                                <i class="fa-solid fa-caret-down" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="sortable-card" data-card-id="media-trigger">
                    <div class="variants-trigger-card">
                        <button type="button" class="variants-trigger-btn" data-bs-toggle="offcanvas"
                            data-bs-target="#mediaLibraryModal" aria-controls="mediaLibraryModal">
                            <span class="variants-trigger-icon"><i class="fa-solid fa-images"
                                    aria-hidden="true"></i></span>
                            <span class="variants-trigger-text">
                                <span class="d-block fw-semibold">Media</span>
                                <span class="d-block small text-muted">Upload and manage product images</span>
                            </span>
                            <span class="variants-trigger-arrow"><i class="fa-solid fa-chevron-right"
                                    aria-hidden="true"></i></span>
                        </button>
                        <div class="card-move-wrap card-move-wrap--inline">
                            <button type="button" class="card-move-btn" data-move="up" title="Move up"
                                aria-label="Move card up">
                                <i class="fa-solid fa-caret-up" aria-hidden="true"></i>
                            </button>
                            <button type="button" class="card-move-btn" data-move="down" title="Move down"
                                aria-label="Move card down">
                                <i class="fa-solid fa-caret-down" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="sortable-card" data-card-id="shipping">
                    <div class="card-move-wrap" data-move-wrap>
                        <button type="button" class="card-move-btn" data-move="up" title="Move up"
                            aria-label="Move card up">
                            <i class="fa-solid fa-caret-up" aria-hidden="true"></i>
                        </button>
                        <button type="button" class="card-move-btn" data-move="down" title="Move down"
                            aria-label="Move card down">
                            <i class="fa-solid fa-caret-down" aria-hidden="true"></i>
                        </button>
                    </div>
                    <div class="card p-4 mb-3">
                        <p class="fs-6 fw-semibold ">Shipping</p>
                        <div class="ship-type-row" role="radiogroup" aria-label="Product shipping type"
                            id="shipTypeRow">
                            <input type="radio" name="ship_type" id="physicalProductBtn" value="physical"
                                class="ship-type-input" checked>
                            <label for="physicalProductBtn" class="ship-type-btn">
                                <i class="fa-solid fa-shirt" aria-hidden="true"></i>
                                <span>Physical product</span>
                            </label>

                            <input type="radio" name="ship_type" id="digitalProductBtn" value="digital"
                                class="ship-type-input">
                            <label for="digitalProductBtn" class="ship-type-btn">
                                <i class="fa-solid fa-cloud-arrow-up" aria-hidden="true"></i>
                                <span>Digital product</span>
                            </label>
                        </div>

                        <div class="py-3 row mb-3" id="shippingDetailsBox">
                            <div class="form-group col-md-6">
                                <label class="field-label" for="weightInput">Weight</label>
                                <input type="number" min="0" step="0.1" inputmode="decimal"
                                    id="weightInput" name="weight" class="form-control" value="5">
                            </div>
                            <div class="form-group col-md-6">
                                <label class="field-label" for="weightUnitSelect">Unit</label>
                                <select class="form-select" id="weightUnitSelect" name="weight_unit">
                                    <option>Kilogram (kg)</option>
                                    <option>Gram (g)</option>
                                    <option>Pound (lb)</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="field-label text-ink-3" style="font-weight:500;"
                                    for="lengthInput">Length</label>
                                <input type="number" min="0" inputmode="decimal" id="lengthInput"
                                    name="length" class="form-control" value="40">
                            </div>
                            <div class="form-group col-md-4">
                                <label class="field-label text-ink-3" style="font-weight:500;"
                                    for="widthInput">Width</label>
                                <input type="number" min="0" inputmode="decimal" id="widthInput" name="width"
                                    class="form-control" value="30">
                            </div>
                            <div class="form-group col-md-4">
                                <label class="field-label text-ink-3" style="font-weight:500;"
                                    for="heightInput">Height</label>
                                <input type="number" min="0" inputmode="decimal" id="heightInput"
                                    name="height" class="form-control" value="20">
                            </div>
                            <div class="form-group col-md-6">
                                <label class="field-label text-ink-3" style="font-weight:500;"
                                    for="dimensionUnitSelect">Unit</label>
                                <select class="form-select" id="dimensionUnitSelect" name="dimension_unit">
                                    <option>Centimeter (cm)</option>
                                    <option>Meter (m)</option>
                                    <option>Inch (in)</option>
                                </select>
                            </div>
                        </div>

                        <div class="alert alert-primary mt-2 p-3 d-none" id="digitalShippingFields">
                            Digital products don't need weight or dimensions — customers get access right after purchase,
                            with
                            nothing to ship.
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-4">
            <div id="col4SortArea">

                <div class="sortable-card" data-card-id="product-chart">
                    <div class="card-move-wrap" data-move-wrap>
                        <button type="button" class="card-move-btn" data-move="up" title="Move up"
                            aria-label="Move card up">
                            <i class="fa-solid fa-caret-up" aria-hidden="true"></i>
                        </button>
                        <button type="button" class="card-move-btn" data-move="down" title="Move down"
                            aria-label="Move card down">
                            <i class="fa-solid fa-caret-down" aria-hidden="true"></i>
                        </button>
                    </div>
                    <div class="card p-4 mb-3">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <p class="fs-6 fw-semibold mb-0">Product Performance</p>
                        </div>
                        <div class="mb-2">
                            <span class="fs-4 fw-bold" id="perfCurrentValue">—</span>
                            <span class="small ms-1" id="perfChangeValue"></span>
                        </div>
                        <div style="height:170px;">
                            <canvas id="productPerformanceChart"></canvas>
                        </div>
                        <div class="text-muted small mt-2 d-none" id="perfErrorMsg">
                            Couldn't load performance data right now.
                        </div>
                    </div>
                </div>

                <div class="sortable-card" data-card-id="stock">
                    <div class="card-move-wrap" data-move-wrap>
                        <button type="button" class="card-move-btn" data-move="up" title="Move up"
                            aria-label="Move card up">
                            <i class="fa-solid fa-caret-up" aria-hidden="true"></i>
                        </button>
                        <button type="button" class="card-move-btn" data-move="down" title="Move down"
                            aria-label="Move card down">
                            <i class="fa-solid fa-caret-down" aria-hidden="true"></i>
                        </button>
                    </div>
                    <div class="card p-4 mb-3">
                        <p class="fs-6 fw-semibold ">Stock</p>
                        <div class="form-group col-12 px-0">
                            <label class="field-label" for="onHandStockInput">On hand stock</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="onHandStockInput" min="0"
                                    value="" id="onHandStockInput" placeholder="0">
                                <button type="button" class="btn btn-dark" id="reorderBtn"
                                    style="white-space:nowrap;">Reorder</button>
                            </div>
                            <div class="form-check ps-0">
                                <input class="form-check-input check-black" type="checkbox" id="continueSellingCheck"
                                    name="continueSellingCheck" checked="">
                                <label class="form-check-label me-0" for="continueSellingCheck">Continue selling when out
                                    of
                                    stock</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="sortable-card" data-card-id="product-org">
                    <div class="card-move-wrap" data-move-wrap>
                        <button type="button" class="card-move-btn" data-move="up" title="Move up"
                            aria-label="Move card up">
                            <i class="fa-solid fa-caret-up" aria-hidden="true"></i>
                        </button>
                        <button type="button" class="card-move-btn" data-move="down" title="Move down"
                            aria-label="Move card down">
                            <i class="fa-solid fa-caret-down" aria-hidden="true"></i>
                        </button>
                    </div>
                    <div class="card p-4 mb-3">
                        <p class="fs-6 fw-semibold ">Product Organization</p>
                        <div class="card-body p-0">
                            <div class="form-group px-0">
                                <label for="sku" class="form-label">SKU </label>
                                <input type="text" class="form-control" name="sku" value="{{ '' }}"
                                    id="sku" placeholder="">
                                @error('sku')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                                <span
                                    class="ms-1 d-inline-flex align-items-center justify-content-center rounded-circle bg-dark text-white"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="custom made by me"
                                    aria-label="Info: custom made by me"
                                    style="width: 16px; height: 16px; font-size: 11px; cursor: help;">i</span>

                            </div>
                            <div class="form-group px-0">
                                <label for="category" class="form-label">Category </label>
                                <select name="category" id="category" class="form-select">
                                    <option value=""></option>
                                </select>
                                @error('category')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group px-0">
                                <label for="type" class="form-label">Type </label>
                                <select name="type" id="type" class="form-select" disabled>
                                    <option value=""></option>
                                </select>
                                @error('type')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group px-0">
                                <label for="vendor" class="form-label">Vendor </label>
                                <select name="vendor" id="vendor" class="form-select">
                                    <option value=""></option>
                                </select>
                                @error('vendor')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group px-0">
                                <label for="tags" class="form-label">Tags </label>
                                <select name="tags" id="tags" class="form-select">
                                    <option value=""></option>
                                </select>
                                @error('tags')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 mt-0">
            <div class="card p-4 mb-3 notes-card">
                <p class="fs-6 fw-semibold ">Notes</p>
                <div class="card-body p-0">
                    <div id="summernote"></div>
                    <div class="mt-3 text-end">
                        <button type="button" id="submitNoteBtn" class="btn btn-dark btn-sm">Submit</button>
                    </div>
                    <div id="summernote-result"></div>
                </div>
            </div>
        </div>

    </div>

    <div class="sticky-action-bar">
        <div class="sticky-action-bar-inner">
            <button type="button" class="btn btn-dark bg-dark-gradient" id="saveDraftBtn">
                <i class="fas fa-file-alt me-2"></i> Save as Draft
            </button>

            <button type="button" class="btn btn-secondary bg-secondary-gradient" id="scheduleBtn">
                <i class="fas fa-calendar-alt me-2"></i> Schedule
            </button>

            <button type="button" class="btn btn-primary bg-primary-gradient" id="publishBtn">
                <i class="fas fa-paper-plane me-2"></i> Publish
            </button>

        </div>
    </div>


    <div class="offcanvas offcanvas-end" tabindex="-1" id="variantsModal" aria-labelledby="variantsModalLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="variantsModalLabel">Variants</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">

            <div class="card p-4 mb-3">
                <p class="fs-6 fw-semibold">Varients</p>
                <div id="variantTypeRows">
                    <div class="row g-0 border p-3 rounded-3 align-items-center variant-type-row">
                        <div class="col-11">
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label class="field-label">Variant type</label>
                                    <select class="form-select variant-type-select" name="variant_type[]">
                                        <option value="Color">Color</option>
                                        <option value="SSD Size">SSD Size</option>
                                        <option value="RAM">RAM</option>
                                        <option value="Size">Size</option>
                                        <option value="Material">Material</option>
                                    </select>
                                </div>
                                <div class="col-md-8 form-group">
                                    <label class="field-label">Variant value</label>
                                    <select class="form-select variant-value-select" data-select="tag"
                                        name="variant_value[]" multiple>
                                        <option value="html">Variant value - 1</option>
                                        <option value="css">Variant value - 2</option>
                                        <option value="js">Variant value - 3</option>
                                        <option value="php">Variant value - 4</option>
                                        <option value="wp">Variant value - 5</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-1 pt-4 ps-4">
                            <button type="button"
                                class="btn mt-2 d-flex py-2 px-1 align-content-center justify-content-center rounded-3 variant-type-delete"
                                title="Delete variant" aria-label="Delete variant">
                                <i class="fa-solid fa-trash fs-5 text-danger" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary col-md-12 mt-2" id="addVariantTypeBtn">
                    <i class="fa-solid fa-plus" aria-hidden="true"></i> Add Another Variation
                </button>
            </div>

            <div class="card p-4 mb-3">
                <p class="fs-6 fw-semibold">Varients Table</p>

                <button type="button" id="generateVariationsBtn" class="btn btn-dark w-100">
                    <i class="fa-solid fa-wand-magic-sparkles" aria-hidden="true"></i> Generate Variations
                </button>

                <div id="generatedVariantsWrap" class="d-none mt-3">
                    <div id="generatedComboRows"></div>
                    <button type="button" id="addComboRowBtn" class="btn btn-secondary col-md-12 mt-2">
                        <i class="fa-solid fa-plus" aria-hidden="true"></i> Add combination manually
                    </button>
                </div>

                <div id="comboRowTemplate" class="d-none">
                    <div class="row g-3 border rounded-3 p-3 mb-2 align-items-center combo-row">
                        <div class="col-auto">
                            <label
                                class="combo-img-picker border rounded d-flex align-items-center justify-content-center text-muted"
                                title="Set image for this combination" aria-label="Set image for this combination"
                                data-combo-image>
                                <svg width="50" height="50" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" transform="rotate(0 0 0)">
                                    <path
                                        d="M19.0752 16.1484C19.4892 16.1487 19.8252 16.4844 19.8252 16.8984C19.8252 17.6853 20.4632 18.323 21.25 18.3232C21.6639 18.3235 21.9999 18.6593 22 19.0732C22 19.4873 21.664 19.823 21.25 19.8232C20.4633 19.8235 19.8254 20.4614 19.8252 21.248C19.8252 21.6621 19.4892 21.9978 19.0752 21.998C18.6611 21.9979 18.3252 21.6622 18.3252 21.248C18.325 20.4614 17.687 19.8235 16.9004 19.8232C16.4862 19.8232 16.1504 19.4875 16.1504 19.0732C16.1505 18.6591 16.4862 18.3232 16.9004 18.3232C17.6872 18.323 18.3252 17.6853 18.3252 16.8984C18.3252 16.4843 18.6611 16.1485 19.0752 16.1484Z"
                                        fill="#343C54" />
                                    <path
                                        d="M8.6543 6.93652C9.55061 6.9366 10.2773 7.66324 10.2773 8.55957C10.2773 9.4559 9.55061 10.1825 8.6543 10.1826C7.75791 10.1826 7.03125 9.45595 7.03125 8.55957C7.03125 7.66319 7.75791 6.93652 8.6543 6.93652Z"
                                        fill="#343C54" />
                                    <path
                                        d="M18.502 3.25C19.7446 3.25 20.752 4.25736 20.752 5.5V15.4033C20.3884 14.9946 19.8792 14.7188 19.3047 14.6602L19.252 14.6572V13.8604L16.9639 10.6963C16.619 10.2193 15.8836 10.3067 15.6611 10.8516L13.6836 15.6982C13.0242 17.3138 10.8563 17.5966 9.80469 16.2041L8.58984 14.5947C8.29091 14.1989 7.69683 14.197 7.39551 14.5908L7.39453 14.5918L4.75195 18.0488V18.5C4.75195 18.9142 5.08774 19.25 5.50195 19.25H14.6582C14.7046 19.8464 14.9832 20.3753 15.4043 20.75H5.50195C4.25931 20.75 3.25195 19.7426 3.25195 18.5V5.5C3.25195 4.25736 4.25931 3.25 5.50195 3.25H18.502ZM5.50195 4.75C5.08774 4.75 4.75195 5.08579 4.75195 5.5V15.5791L6.20312 13.6807L6.29004 13.5732C7.21689 12.4991 8.91693 12.5398 9.78613 13.6904L11.002 15.2998C11.3524 15.7639 12.075 15.6701 12.2949 15.1318L14.2725 10.2852C14.9397 8.65007 17.145 8.38624 18.1797 9.81738L19.252 11.3008V5.5C19.252 5.08579 18.9162 4.75 18.502 4.75H5.50195Z"
                                        fill="#343C54" />
                                </svg>
                                <img src="" alt="Variant combination image" data-combo-preview>
                                <span class="combo-img-overlay" data-combo-overlay><i class="fa-solid fa-pen"
                                        aria-hidden="true"></i></span>
                                <button type="button" class="combo-img-remove" data-combo-remove
                                    aria-label="Remove image" title="Remove image"><i class="fa-solid fa-xmark"
                                        aria-hidden="true"></i></button>
                                <input type="file" accept="image/*" data-img-input="" name="variant_image[]">
                                <input type="hidden" name="variant_image_url[]" data-combo-value value="">
                            </label>
                        </div>
                        <div class="col">
                            <div class="variant-pills mb-2 ps-2"></div>
                            <div class="row g-2">
                                <div class="col-md-4 form-group">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa-solid fa-barcode"
                                                aria-hidden="true"></i></span>
                                        <input type="text" class="form-control" placeholder="SKU" data-sku=""
                                            name="variant_sku[]" value="">
                                    </div>
                                </div>
                                <div class="col-md-4 form-group">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa-solid fa-tag"
                                                aria-hidden="true"></i></span>
                                        <input type="text" class="form-control" placeholder="Price" data-price=""
                                            name="variant_price[]" value="">
                                    </div>
                                </div>
                                <div class="col-md-4 form-group">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa-solid fa-boxes-stacked"
                                                aria-hidden="true"></i></span>
                                        <input type="text" class="form-control" placeholder="Stock" data-stock=""
                                            name="variant_stock[]" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn mt-2 d-flex py-2 px-1 mt-4 combo-row-delete"
                                title="Delete variant" aria-label="Delete variant">
                                <i class="fa-solid fa-trash fs-5 text-danger mt-1" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="offcanvas-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Close</button>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="mediaLibraryModal" aria-labelledby="mediaLibraryModalLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="mediaLibraryModalLabel">Media</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="mm-dropzone" id="mediaLibDropzone">
                <i class="fa-solid fa-cloud-arrow-up"></i>
                <div class="mm-drop-title">Drag and drop images here</div>
                <div class="mm-drop-sub">or click to browse from your computer</div>
            </div>
            <input type="file" id="mediaLibFileInput" accept="image/*" multiple class="d-none">

            <div class="mm-library-grid mt-3" id="mediaLibGrid"></div>
        </div>
    </div>

    <div class="modal-overlay" id="lightboxOverlay">
        <div class="lightbox-content">
            <button type="button" class="modal-close lightbox-close" id="lightboxClose" aria-label="Close"><i
                    class="fa-solid fa-xmark"></i></button>
            <img src="" alt="" id="lightboxImage">
        </div>
    </div>

    <div class="modal-overlay" id="mediaModalOverlay">
        <div class="media-modal">
            <div class="media-modal-header">
                <div class="media-modal-title" id="mediaModalTitle">Add combination image</div>
                <button type="button" class="modal-close" id="mediaModalClose" aria-label="Close"><i
                        class="fa-solid fa-xmark"></i></button>
            </div>

            <div class="media-modal-tabs" id="mediaModalTabs">
                <button type="button" class="mm-tab active" data-tab="upload">Upload</button>
                <button type="button" class="mm-tab" data-tab="library">Select from library</button>
            </div>

            <div class="media-modal-body">
                <div class="mm-panel active" id="mmUploadPanel">
                    <div class="mm-dropzone" id="mmDropzone">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                        <div class="mm-drop-title">Drag and drop an image here</div>
                        <div class="mm-drop-sub">or click to browse from your computer</div>
                    </div>
                    <input type="file" id="mmFileInput" accept="image/*" class="d-none">
                </div>

                <div class="mm-panel" id="mmLibraryPanel">
                    <div class="mm-library-toolbar">
                        <div class="mm-search-box">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" id="mmLibrarySearch" placeholder="Search image library">
                        </div>
                        <div class="mm-selected-count" id="mmSelectedCount">0 selected</div>
                    </div>
                    <div class="mm-library-grid" id="mmLibraryGrid"></div>
                </div>
            </div>

            <div class="media-modal-footer">
                <button type="button" class="btn btn-outline-secondary" id="mediaModalCancel">Cancel</button>
                <button type="button" class="btn btn-dark" id="mediaModalAdd" disabled>Add image</button>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice.select2-selection__choice {
            display: inline-flex;
            align-items: center;
            background-color: #1a1a1a;
            border: 1px solid #1a1a1a;
            border-radius: 6px;
            padding: 0;
            padding-left: 5px;
            padding-right: 0;
            margin: 4px 0 0 6px;
            font-size: 14px;
            font-weight: 500;
            line-height: 24px;
            color: #fff;
            transition: background-color 0.15s ease, border-color 0.15s ease;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice.select2-selection__choice:hover {
            background-color: #333;
            border-color: #333;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__display.select2-selection__choice__display {
            padding-left: 4px;
            padding-right: 6px;
            color: inherit;
            font-weight: 500;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove.select2-selection__choice__remove {
            position: static;
            left: auto;
            order: 2;
            border: none;
            border-left: 1px solid rgba(255, 255, 255, 0.25);
            border-right: none;
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
            border-top-right-radius: 6px;
            border-bottom-right-radius: 6px;
            padding: 0 5px;
            color: #fff;
            background-color: transparent;
            font-weight: 500;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove.select2-selection__choice__remove:hover,
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove.select2-selection__choice__remove:focus {
            background-color: #fff;
            color: #000;
            outline: none;
        }

        .select2-container--default[dir=rtl] .select2-selection--multiple .select2-selection__choice.select2-selection__choice {
            padding-left: 10px;
            padding-right: 0;
            margin-left: 6px;
            margin-right: 0;
        }
    </style>
@endpush
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
    <script>
        $(function() {
            $('input[name="ship_type"]').on('change', function() {
                $('#shippingDetailsBox').toggleClass('d-none', this.value === 'digital');
                $('#digitalShippingFields').toggleClass('d-none', this.value === 'physical');
            }).filter(':checked').trigger('change');
        });

        $('#summernote').summernote({
            placeholder: 'Write Here',
            tabsize: 2,
            height: 120,
            toolbar: [
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['color', []],
                ['insert', ['link', 'picture']],
                ['view', ['codeview']]
            ]
        });

        // Variant combination image: upload / library picker
        const MEDIA_LIBRARY = [{
                id: 'lib1',
                name: 'Black — front',
                url: 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=200&q=80'
            },
            {
                id: 'lib2',
                name: 'Black — side',
                url: 'https://images.unsplash.com/photo-1508685096489-7aacd43bd3b1?w=200&q=80'
            },
            {
                id: 'lib3',
                name: 'Silver — front',
                url: 'https://images.unsplash.com/photo-1544117519-31a4b719223d?w=200&q=80'
            },
            {
                id: 'lib4',
                name: 'Packaging',
                url: 'https://images.unsplash.com/photo-1622434641406-a158123450f9?w=200&q=80'
            },
            {
                id: 'lib5',
                name: 'On desk',
                url: 'https://images.unsplash.com/photo-1434493907317-a46b5bbe7834?w=200&q=80'
            },
            {
                id: 'lib6',
                name: 'Top view',
                url: 'https://images.unsplash.com/photo-1533139502658-0198f920d8e8?w=200&q=80'
            }
        ];

        // Media library sidebar: upload images and view them in a lightbox (no selection)
        (function() {
            const $grid = $('#mediaLibGrid');
            const $dropzone = $('#mediaLibDropzone');
            const $fileInput = $('#mediaLibFileInput');

            function addImageToGrid(url, name) {
                $grid.prepend(
                    $('<div class="mm-library-item" data-lightbox-src="' + url + '">' +
                        '<img src="' + url + '" alt="' + (name || 'Product image') + '">' +
                        '<span class="mm-name">' + (name || 'Product image') + '</span>' +
                        '</div>')
                );
            }

            MEDIA_LIBRARY.forEach(function(item) {
                addImageToGrid(item.url, item.name);
            });

            function handleLibraryUploadFiles(fileList) {
                Array.from(fileList || []).filter(function(f) {
                    return f.type.startsWith('image/');
                }).forEach(function(file) {
                    const reader = new FileReader();
                    reader.onload = function(ev) {
                        addImageToGrid(ev.target.result, file.name);
                    };
                    reader.readAsDataURL(file);
                });
            }

            $dropzone.on('click', function() {
                $fileInput.trigger('click');
            });
            $dropzone.on('dragover', function(e) {
                e.preventDefault();
                $(this).addClass('drag-over');
            });
            $dropzone.on('dragleave', function() {
                $(this).removeClass('drag-over');
            });
            $dropzone.on('drop', function(e) {
                e.preventDefault();
                $(this).removeClass('drag-over');
                handleLibraryUploadFiles(e.originalEvent.dataTransfer.files);
            });
            $fileInput.on('change', function(e) {
                handleLibraryUploadFiles(e.target.files);
                $(this).val('');
            });

            $(document).on('click', '#mediaLibGrid .mm-library-item', function() {
                $('#lightboxImage').attr('src', $(this).data('lightbox-src'));
                $('#lightboxOverlay').addClass('show');
            });

            function closeLightbox() {
                $('#lightboxOverlay').removeClass('show');
                $('#lightboxImage').attr('src', '');
            }

            $('#lightboxClose').on('click', closeLightbox);
            $('#lightboxOverlay').on('click', function(e) {
                if (e.target === this) closeLightbox();
            });
            $(document).on('keydown', function(e) {
                if (e.key === 'Escape') closeLightbox();
            });
        })();

        // Product Performance chart — demo data from a free, key-free public API
        // (CoinGecko's keyless market_chart endpoint) standing in for a real
        // sales/traffic endpoint. Swap fetchPerformanceSeries() for your own
        // backend call later. If the API or the Chart.js CDN is unreachable,
        // a locally generated series is used instead so the card never sits blank.
        (function() {
            const $current = $('#perfCurrentValue');
            const $change = $('#perfChangeValue');
            const $error = $('#perfErrorMsg');
            const canvas = document.getElementById('productPerformanceChart');
            if (!canvas) return;

            function formatLabel(d) {
                return d.toLocaleDateString(undefined, {
                    month: 'short',
                    day: 'numeric'
                });
            }

            function fetchPerformanceSeries() {
                const url = 'https://api.coingecko.com/api/v3/coins/bitcoin/market_chart' +
                    '?vs_currency=usd&days=14&interval=daily';

                return fetch(url).then(function(res) {
                    if (!res.ok) throw new Error('Request failed: ' + res.status);
                    return res.json();
                }).then(function(data) {
                    const points = data.prices || [];
                    if (!points.length) throw new Error('Empty series');
                    return {
                        labels: points.map(function(p) {
                            return formatLabel(new Date(p[0]));
                        }),
                        values: points.map(function(p) {
                            return p[1];
                        })
                    };
                });
            }

            // Used only if the live API call above fails (offline, rate-limited,
            // blocked by network policy, etc.) so the chart still has something to draw.
            function buildFallbackSeries() {
                const labels = [];
                const values = [];
                const today = new Date();
                let value = 800 + Math.random() * 200;
                for (let i = 13; i >= 0; i--) {
                    const d = new Date(today);
                    d.setDate(today.getDate() - i);
                    value = Math.max(50, value + (Math.random() - 0.45) * 40);
                    labels.push(formatLabel(d));
                    values.push(Math.round(value * 100) / 100);
                }
                return {
                    labels: labels,
                    values: values
                };
            }

            function renderChart(series) {
                const last = series.values[series.values.length - 1];
                const first = series.values[0];
                const pctChange = first ? ((last - first) / first) * 100 : 0;

                $current.text('$' + last.toLocaleString(undefined, {
                    maximumFractionDigits: 2
                }));
                $change.text((pctChange >= 0 ? '+' : '') + pctChange.toFixed(2) + '%')
                    .css('color', pctChange >= 0 ? '#0f9d58' : '#d93025');

                new Chart(canvas, {
                    type: 'line',
                    data: {
                        labels: series.labels,
                        datasets: [{
                            label: 'Performance',
                            data: series.values,
                            borderColor: '#111',
                            backgroundColor: 'rgba(17,17,17,0.08)',
                            fill: true,
                            tension: 0.35,
                            pointRadius: 0,
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    maxTicksLimit: 5,
                                    font: {
                                        size: 10
                                    }
                                }
                            },
                            y: {
                                grid: {
                                    color: '#f1f1f1'
                                },
                                ticks: {
                                    font: {
                                        size: 10
                                    }
                                }
                            }
                        }
                    }
                });
            }

            fetchPerformanceSeries()
                .catch(function() {
                    return buildFallbackSeries();
                })
                .then(function(series) {
                    if (typeof Chart === 'undefined') throw new Error('Chart.js not loaded');
                    renderChart(series);
                })
                .catch(function() {
                    $error.removeClass('d-none');
                });
        })();

        let mmSelectedLibraryId = null;
        let comboImageTarget = null;

        function renderLibraryGrid(filter) {
            const q = (filter || '').trim().toLowerCase();
            const $grid = $('#mmLibraryGrid').empty();
            MEDIA_LIBRARY
                .filter(item => !q || item.name.toLowerCase().includes(q))
                .forEach(item => {
                    const selected = mmSelectedLibraryId === item.id;
                    $grid.append(
                        $('<div class="mm-library-item' + (selected ? ' selected' : '') + '" data-lib-id="' + item
                            .id + '">' +
                            '<img src="' + item.url + '" alt="' + item.name + '">' +
                            '<span class="mm-check"><i class="fa-solid fa-check"></i></span>' +
                            '<span class="mm-name">' + item.name + '</span>' +
                            '</div>')
                    );
                });
        }

        function updateAddButtonState() {
            const uploadActive = $('#mmUploadPanel').hasClass('active');
            const $addBtn = $('#mediaModalAdd');
            if (uploadActive) {
                $addBtn.prop('disabled', true);
            } else {
                $addBtn.prop('disabled', !mmSelectedLibraryId);
            }
        }

        function openMediaModal($target) {
            comboImageTarget = $target;
            mmSelectedLibraryId = null;
            $('#mmLibrarySearch').val('');
            renderLibraryGrid('');
            $('.mm-tab').removeClass('active').filter('[data-tab="upload"]').addClass('active');
            $('.mm-panel').removeClass('active');
            $('#mmUploadPanel').addClass('active');
            updateAddButtonState();
            $('#mediaModalOverlay').addClass('show');
        }

        function closeMediaModal() {
            $('#mediaModalOverlay').removeClass('show');
            comboImageTarget = null;
        }

        function setComboImage(url) {
            if (!comboImageTarget) return;
            comboImageTarget.addClass('has-image');
            comboImageTarget.find('[data-combo-preview]').attr('src', url);
            comboImageTarget.find('[data-combo-value]').val(url);
        }

        $(document).on('click', '[data-combo-image]', function(e) {
            e.preventDefault();
            openMediaModal($(this));
        });

        $(document).on('click', '[data-combo-remove]', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const $picker = $(this).closest('[data-combo-image]');
            $picker.removeClass('has-image');
            $picker.find('[data-combo-preview]').attr('src', '');
            $picker.find('[data-combo-value]').val('');
        });

        $('#mediaModalClose, #mediaModalCancel').on('click', closeMediaModal);
        $('#mediaModalOverlay').on('click', function(e) {
            if (e.target === this) closeMediaModal();
        });
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape') closeMediaModal();
        });

        $('#mediaModalTabs').on('click', '.mm-tab', function() {
            $('.mm-tab').removeClass('active');
            $(this).addClass('active');
            const tab = $(this).data('tab');
            $('.mm-panel').removeClass('active');
            $('#mm' + (tab === 'upload' ? 'Upload' : 'Library') + 'Panel').addClass('active');
            updateAddButtonState();
        });

        $('#mmDropzone').on('click', function() {
            $('#mmFileInput').trigger('click');
        });
        $('#mmDropzone').on('dragover', function(e) {
            e.preventDefault();
            $(this).addClass('drag-over');
        });
        $('#mmDropzone').on('dragleave', function() {
            $(this).removeClass('drag-over');
        });
        $('#mmDropzone').on('drop', function(e) {
            e.preventDefault();
            $(this).removeClass('drag-over');
            handleUploadFiles(e.originalEvent.dataTransfer.files);
        });
        $('#mmFileInput').on('change', function(e) {
            handleUploadFiles(e.target.files);
            $(this).val('');
        });

        function handleUploadFiles(fileList) {
            const file = Array.from(fileList || []).find(f => f.type.startsWith('image/'));
            if (!file) return;
            const reader = new FileReader();
            reader.onload = function(ev) {
                setComboImage(ev.target.result);
                closeMediaModal();
            };
            reader.readAsDataURL(file);
        }

        $('#mmLibrarySearch').on('input', function() {
            renderLibraryGrid($(this).val());
        });

        $('#mmLibraryGrid').on('click', '.mm-library-item', function() {
            mmSelectedLibraryId = $(this).data('lib-id');
            renderLibraryGrid($('#mmLibrarySearch').val());
            updateAddButtonState();
        });

        $('#mediaModalAdd').on('click', function() {
            if ($(this).prop('disabled')) return;
            const item = MEDIA_LIBRARY.find(i => i.id === mmSelectedLibraryId);
            if (item) setComboImage(item.url);
            closeMediaModal();
        });

        $('#submitNoteBtn').on('click', function() {
            if ($('#summernote').summernote('isEmpty')) {
                return;
            }

            let content = $('#summernote').summernote('code');
            const temp = $('<div>').html(content);

            temp.find('img').each(function() {
                const src = $(this).attr('src');
                const iconLink = $('<a>')
                    .attr('href', src)
                    .attr('target', '_blank')
                    .attr('rel', 'noopener noreferrer')
                    .addClass('text-secondary')
                    .html('<i class="fa-solid fa-image"></i> View image');

                $(this).replaceWith(iconLink);
            });

            content = temp.html();
            $('#summernote-result').html(content);

            $('#summernote').summernote('reset');
        });

        // Card reordering: up/down buttons, order saved to a cookie (falls back to localStorage)
        (function() {
            const COOKIE_DAYS = 365;

            function cookiesAvailable() {
                if (!navigator.cookieEnabled) return false;
                try {
                    document.cookie = 'cookie_test=1;path=/;SameSite=Lax';
                    const ok = document.cookie.indexOf('cookie_test=') !== -1;
                    document.cookie = 'cookie_test=;path=/;max-age=0';
                    return ok;
                } catch (e) {
                    return false;
                }
            }

            function setCookie(key, value) {
                const maxAge = COOKIE_DAYS * 24 * 60 * 60;
                document.cookie = key + '=' + encodeURIComponent(value) + ';path=/;max-age=' + maxAge + ';SameSite=Lax';
            }

            function getCookie(key) {
                const match = document.cookie.match(new RegExp('(?:^|; )' + key + '=([^;]*)'));
                return match ? decodeURIComponent(match[1]) : null;
            }

            function saveOrder(key, orderArray) {
                const value = JSON.stringify(orderArray);
                if (cookiesAvailable()) {
                    setCookie(key, value);
                } else {
                    try {
                        localStorage.setItem(key, value);
                    } catch (e) {}
                }
            }

            function loadOrder(key) {
                const fromCookie = getCookie(key);
                if (fromCookie) {
                    try {
                        return JSON.parse(fromCookie);
                    } catch (e) {}
                }
                try {
                    const fromLocal = localStorage.getItem(key);
                    if (fromLocal) return JSON.parse(fromLocal);
                } catch (e) {}
                return null;
            }

            function swapNodes(n1, n2) {
                const parent = n1.parentNode;
                if (!parent || n2.parentNode !== parent) return;
                if (n1.nextSibling === n2) {
                    parent.insertBefore(n2, n1);
                    return;
                }
                if (n2.nextSibling === n1) {
                    parent.insertBefore(n1, n2);
                    return;
                }
                const next1 = n1.nextSibling;
                const next2 = n2.nextSibling;
                parent.insertBefore(n1, next2);
                parent.insertBefore(n2, next1);
            }

            function findAdjacentCard(card, direction) {
                let el = direction === 'up' ? card.previousElementSibling : card.nextElementSibling;
                while (el && !el.classList.contains('sortable-card')) {
                    el = direction === 'up' ? el.previousElementSibling : el.nextElementSibling;
                }
                return el;
            }

            function initSortableGroup(containerId, storageKey) {
                const container = document.getElementById(containerId);
                if (!container) return;

                const savedOrder = loadOrder(storageKey);
                if (savedOrder && savedOrder.length) {
                    savedOrder.forEach(function(cardId) {
                        const el = container.querySelector(':scope > .sortable-card[data-card-id="' + cardId +
                            '"]');
                        if (el) container.appendChild(el);
                    });
                }

                function cardList() {
                    return Array.from(container.querySelectorAll(':scope > .sortable-card'));
                }

                function refreshDisabledStates() {
                    const cards = cardList();
                    cards.forEach(function(card, i) {
                        card.querySelector('[data-move="up"]').disabled = (i === 0);
                        card.querySelector('[data-move="down"]').disabled = (i === cards.length - 1);
                    });
                }

                container.addEventListener('click', function(e) {
                    const moveBtn = e.target.closest('[data-move]');
                    if (!moveBtn || moveBtn.disabled) return;
                    const card = moveBtn.closest('.sortable-card');
                    const target = findAdjacentCard(card, moveBtn.dataset.move);
                    if (!target) return;
                    swapNodes(card, target);
                    refreshDisabledStates();
                    saveOrder(storageKey, cardList().map(function(el) {
                        return el.dataset.cardId;
                    }));
                });

                refreshDisabledStates();
            }

            initSortableGroup('col8SortArea', 'productFormCardOrder_col8');
            initSortableGroup('col4SortArea', 'productFormCardOrder_col4');
        })();

        // Variant type rows: add / remove
        (function() {
            const $wrap = $('#variantTypeRows');
            const template = $wrap.find('.variant-type-row').first().clone();

            $('#addVariantTypeBtn').on('click', function() {
                const $row = template.clone();
                $row.find('.variant-type-select').prop('selectedIndex', 0);
                $row.find('.variant-value-select').val([]);
                $wrap.append($row);
            });

            $(document).on('click', '.variant-type-delete', function() {
                if ($wrap.find('.variant-type-row').length <= 1) return;
                $(this).closest('.variant-type-row').remove();
            });
        })();

        // Variants Table: generate combinations from the variant type rows above,
        // or add a combination manually. Both feed the same row list.
        (function() {
            const $rowsContainer = $('#generatedComboRows');
            const $wrap = $('#generatedVariantsWrap');
            const rowTemplate = $('#comboRowTemplate .combo-row').first();

            function blankRow(pillsHtml) {
                const $row = rowTemplate.clone();
                $row.find('.variant-pills').html(pillsHtml || '<span class="variant-pill">New combination</span>');
                return $row;
            }

            $('#generateVariationsBtn').on('click', function() {
                const rows = $('#variantTypeRows .variant-type-row').map(function() {
                    const typeEl = $(this).find('.variant-type-select')[0];
                    const valueEl = $(this).find('.variant-value-select')[0];
                    return {
                        type: typeEl.options[typeEl.selectedIndex].text,
                        values: Array.from(valueEl.selectedOptions).map(function(o) {
                            return o.text;
                        })
                    };
                }).get().filter(function(r) {
                    return r.values.length;
                });

                if (!rows.length) return;

                let combos = [
                    []
                ];
                rows.forEach(function(r) {
                    const next = [];
                    combos.forEach(function(c) {
                        r.values.forEach(function(v) {
                            next.push(c.concat([{
                                type: r.type,
                                value: v
                            }]));
                        });
                    });
                    combos = next;
                });

                $rowsContainer.empty();
                combos.forEach(function(combo) {
                    const pillsHtml = combo.map(function(c) {
                        return '<span class="variant-pill">' + c.type + ': ' + c.value +
                            '</span>';
                    }).join('');
                    $rowsContainer.append(blankRow(pillsHtml));
                });
                $wrap.removeClass('d-none');
            });

            $('#addComboRowBtn').on('click', function() {
                $rowsContainer.append(blankRow());
                $wrap.removeClass('d-none');
            });

            $(document).on('click', '.combo-row-delete', function() {
                $(this).closest('.combo-row').remove();
            });
        })();

        // Sticky bottom action bar — status is tracked in a hidden field;
        // wire the actual save/schedule/publish requests to your own endpoints.
        (function() {
            const $status = $('<input type="hidden" name="status" id="productStatusInput" value="draft">');
            $('body').append($status);

            function setStatus(value, $btn) {
                $status.val(value);
                $btn.prop('disabled', true).data('originalText', $btn.html());
                setTimeout(function() {
                    $btn.prop('disabled', false);
                }, 600);
            }

            $('#saveDraftBtn').on('click', function() {
                setStatus('draft', $(this));
            });
            $('#scheduleBtn').on('click', function() {
                setStatus('scheduled', $(this));
            });
            $('#publishBtn').on('click', function() {
                setStatus('published', $(this));
            });
        })();
    </script>
@endpush

@push('css')
    <style>
        .card {
            box-shadow: 1px 4px 15px 0px rgb(0 0 0 / 15%);
            border-radius: 5px;
        }

        .check-black[type=checkbox],
        .check-black[type=checkbox] {
            border-color: #bbb;
            background-color: #efefef;
            width: 1.22rem;
            height: 1.22rem;
            letter-spacing: 0px;
            word-spacing: 0px;
        }

        .check-black[type="checkbox"]:checked,
        .check-black[type="checkbox"]:indeterminate {
            background-color: #111111;
            border-color: #111111;
        }

        .form-select {
            padding: .6rem 1rem;
            border: 2px solid #dee2e6;
        }

        .ship-type-row {
            display: flex;
            gap: 5px;
            width: 400px;
            max-width: 100%;
            padding: 1px;
            background: #EFEFEF;
            border: 1px solid #dddddd;
            border-radius: 6px;
        }

        .ship-type-input {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }

        .ship-type-btn {
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px;
            border: 1px solid transparent;
            border-radius: 5px;
            background: transparent;
            color: #777d86;
            font: inherit;
            font-size: 14px;
            font-weight: 500;
            white-space: nowrap;
            cursor: pointer;
            transition: color .2s ease, background .2s ease, box-shadow .2s ease, border-color .2s ease;
        }

        .ship-type-btn i {
            font-size: 15px;
            color: #8b9097;
            transition: color .2s ease;
        }

        .ship-type-btn:hover {
            color: #353a42;
        }

        .ship-type-btn:hover i {
            color: #555b63;
        }

        .ship-type-input:checked+.ship-type-btn {
            background: #ffffff;
            color: #111;
            border-color: #d7d9db;
            box-shadow: 0 0px 6px rgb(0 0 0 / 20%);
        }

        .ship-type-input:checked+.ship-type-btn i {
            color: #2563eb;
        }

        .ship-type-input:focus-visible+.ship-type-btn {
            outline: 2px solid rgba(0, 0, 0, .18);
            outline-offset: 2px;
        }

        @media (max-width: 600px) {
            .ship-type-row {
                width: calc(100% - 30px);
            }

            .ship-type-btn {
                padding: 11px 8px;
                font-size: 13px;
            }
        }

        #summernote p {
            margin-bottom: 0;
        }

        .combo-img-picker {
            width: 64px;
            height: 64px;
            flex-shrink: 0;
            cursor: pointer;
            overflow: hidden;
            position: relative;
            background: #ececec;
        }

        .combo-img-picker img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: none;
        }

        .combo-img-picker.has-image svg {
            display: none;
        }

        .combo-img-picker.has-image img {
            display: block;
        }

        .combo-img-picker .combo-img-overlay {
            position: absolute;
            inset: 0;
            background: rgba(17, 17, 17, .45);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 14px;
            opacity: 0;
            transition: opacity .15s ease;
        }

        .combo-img-picker.has-image:hover .combo-img-overlay {
            opacity: 1;
        }

        .combo-img-picker .combo-img-remove {
            position: absolute;
            top: 3px;
            right: 3px;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: rgba(17, 17, 17, .7);
            color: #fff;
            border: none;
            font-size: 9px;
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 2;
        }

        .combo-img-picker.has-image .combo-img-remove {
            display: flex;
        }

        /* Card reordering */
        .sortable-card {
            position: relative;
        }

        .card-move-wrap {
            position: absolute;
            top: 14px;
            right: 14px;
            z-index: 5;
            display: flex;
            gap: 2px;
        }

        .card-move-btn {
            width: 26px;
            height: 26px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            border-radius: 6px;
            background: transparent;
            color: #a1a5ab;
            cursor: pointer;
        }

        .card-move-btn:hover:not(:disabled) {
            background: #f1f1f1;
            color: #333;
        }

        .card-move-btn:disabled {
            opacity: .3;
            cursor: not-allowed;
        }

        .variants-trigger-card {
            display: flex;
            align-items: stretch;
            background: #fff;
            border: 1px solid #eee;
            border-radius: 8px;
            margin-bottom: 1rem;
            box-shadow: 1px 4px 15px 0px rgb(0 0 0 / 15%);
            transition: box-shadow .15s ease, transform .15s ease;
        }

        .variants-trigger-card:hover {
            box-shadow: 0 6px 20px rgb(0 0 0 / 18%);
        }

        .card-move-wrap--inline {
            position: static;
            flex-shrink: 0;
            align-items: center;
            padding: 0 12px;
            border-left: 1px solid #eee;
        }

        .variants-trigger-btn {
            display: flex;
            align-items: center;
            gap: 14px;
            flex: 1;
            min-width: 0;
            text-align: left;
            background: transparent;
            border: none;
            border-radius: 8px;
            padding: 18px 20px;
        }

        .variants-trigger-icon {
            width: 42px;
            height: 42px;
            border-radius: 8px;
            background: #111;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
            flex-shrink: 0;
        }

        .variants-trigger-text {
            flex: 1;
        }

        .variants-trigger-arrow {
            color: #999;
        }

        #variantsModal {
            --bs-offcanvas-width: 880px;
        }

        #variantsModal .offcanvas-body {
            background: #f8f9fa;
        }

        #mediaLibraryModal {
            --bs-offcanvas-width: 640px;
        }

        .lightbox-content {
            position: relative;
            max-width: 90vw;
            max-height: 90vh;
        }

        .lightbox-content img {
            max-width: 90vw;
            max-height: 90vh;
            border-radius: 10px;
            display: block;
        }

        .lightbox-close {
            position: absolute;
            top: -14px;
            right: -14px;
            background: #fff;
        }

        .offcanvas-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding: 16px 22px;
            border-top: 1px solid #dee2e6;
            flex-shrink: 0;
        }

        /* Sticky bottom action bar */
        .sticky-action-bar {
            position: sticky;
            bottom: 0;
            left: 0;
            right: 0;
            background: #fff;
            border-top: 1px solid #e5e5e5;
            box-shadow: 0 -6px 20px rgb(0 0 0 / 8%);
            z-index: 1040;
            margin-top: 1.5rem;
        }

        .sticky-action-bar-inner {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding: 14px 20px;
        }

        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(17, 17, 17, .55);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1060;
            padding: 20px;
        }

        .modal-overlay.show {
            display: flex;
        }

        .media-modal {
            background: #fff;
            border-radius: 18px;
            width: 100%;
            max-width: 620px;
            max-height: 84vh;
            display: flex;
            flex-direction: column;
            box-shadow: 0 24px 60px rgba(20, 20, 40, .28);
            overflow: hidden;
        }

        .media-modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 22px;
            border-bottom: 1px solid #dee2e6;
            flex-shrink: 0;
        }

        .media-modal-title {
            font-size: 15.5px;
            font-weight: 600;
        }

        .modal-close {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            background: #efefef;
            border: none;
            color: #6c757d;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
        }

        .modal-close:hover {
            background: #dee2e6;
            color: #111;
        }

        .media-modal-tabs {
            display: flex;
            gap: 4px;
            padding: 12px 22px 0;
            border-bottom: 1px solid #dee2e6;
            flex-shrink: 0;
        }

        .mm-tab {
            background: none;
            border: none;
            padding: 10px 4px 12px;
            margin-right: 20px;
            font-size: 13.5px;
            font-weight: 500;
            color: #6c757d;
            border-bottom: 2px solid transparent;
        }

        .mm-tab.active {
            color: #111;
            border-bottom-color: #111;
        }

        .media-modal-body {
            padding: 22px;
            overflow-y: auto;
            flex: 1;
            min-height: 320px;
        }

        .mm-panel {
            display: none;
        }

        .mm-panel.active {
            display: block;
        }

        .mm-dropzone {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border: 1.5px dashed #d5d4e4;
            border-radius: 14px;
            padding: 52px 20px;
            text-align: center;
            cursor: pointer;
            color: #6c757d;
            transition: border-color .15s ease, background .15s ease;
        }

        .mm-dropzone.drag-over,
        .mm-dropzone:hover {
            border-color: #111;
            background: #f1f1f1;
            color: #111;
        }

        .mm-dropzone i {
            font-size: 30px;
            margin-bottom: 12px;
        }

        .mm-dropzone:hover .mm-drop-title,
        .mm-dropzone.drag-over .mm-drop-title {
            color: #111;
        }

        .mm-drop-title {
            font-size: 14px;
            font-weight: 600;
            color: #212529;
            margin-bottom: 4px;
        }

        .mm-drop-sub {
            font-size: 12.5px;
            color: #6c757d;
        }

        .mm-library-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 16px;
        }

        .mm-search-box {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 8px;
            background: #efefef;
            border-radius: 10px;
            padding: 9px 14px;
            color: #6c757d;
            font-size: 13px;
        }

        .mm-search-box input {
            border: none;
            background: transparent;
            outline: none;
            font-size: 13px;
            color: #212529;
            width: 100%;
        }

        .mm-selected-count {
            font-size: 12.5px;
            color: #6c757d;
            font-weight: 500;
            white-space: nowrap;
        }

        .mm-library-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
        }

        .mm-library-item {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            cursor: pointer;
            aspect-ratio: 1 / 1;
            background: #efefef;
            border: 2px solid transparent;
        }

        .mm-library-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .mm-library-item .mm-check {
            position: absolute;
            top: 7px;
            right: 7px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .9);
            border: 1.5px solid #d5d4e4;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            color: transparent;
            transition: all .12s ease;
        }

        .mm-library-item.selected {
            border-color: #111;
        }

        .mm-library-item.selected .mm-check {
            background: #111;
            border-color: #111;
            color: #fff;
        }

        .mm-library-item .mm-name {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(0deg, rgba(0, 0, 0, .55), transparent);
            color: #fff;
            font-size: 10.5px;
            padding: 12px 8px 6px;
            text-overflow: ellipsis;
            overflow: hidden;
            white-space: nowrap;
        }

        @media (max-width: 575px) {
            .mm-library-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        .media-modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding: 16px 22px;
            border-top: 1px solid #dee2e6;
            flex-shrink: 0;
        }

        input[type=file] {
            display: none;
        }

        .variant-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .variant-pill {
            padding: 3px 10px;
            border-radius: 5px;
            font-size: 13px;
            line-height: normal;
            font-weight: 600;
            letter-spacing: 0.3px;
            border: 1px solid #88888820;
        }

        .variant-pills .variant-pill:nth-child(5n+1) {
            background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
            color: #3730a3;
        }

        .variant-pills .variant-pill:nth-child(5n+2) {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            color: #065f46;
        }

        .variant-pills .variant-pill:nth-child(5n+3) {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            color: #92400e;
        }

        .variant-pills .variant-pill:nth-child(5n+4) {
            background: linear-gradient(135deg, #fce7f3, #fbcfe8);
            color: #9d174d;
        }

        .variant-pills .variant-pill:nth-child(5n+5) {
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            color: #1e40af;
        }
    </style>
@endpush
