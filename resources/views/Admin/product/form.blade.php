@extends('admin.layout.app')

@section('content')
    @php
        $triggers = [
            [
                'id' => 'variants-trigger',
                'target' => 'variantsModal',
                'icon' => 'fa-layer-group',
                'title' => 'Variants',
                'desc' => 'Manage variant types and combinations',
            ],
            [
                'id' => 'media-trigger',
                'target' => 'mediaLibraryModal',
                'icon' => 'fa-images',
                'title' => 'Media',
                'desc' => 'Upload and manage product images',
            ],
        ];
    @endphp

    <div class="row g-3">

        <div class="col-8">
            <div id="col8SortArea">

                <div class="sortable-card" data-card-id="product-details">
                    <div class="card p-4 mb-3">
                        <p class="fs-6 fw-semibold">Product Details</p>
                        <div class="row">
                            <div class="form-group col-12">
                                <label for="name" class="form-label">Product Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    value="{{ old('name') }}" placeholder="Enter product name">
                                @error('name')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
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

                @foreach ($triggers as $t)
                    <div class="sortable-card" data-card-id="{{ $t['id'] }}">
                        <div class="variants-trigger-card">
                            <button type="button" class="variants-trigger-btn" data-bs-toggle="offcanvas"
                                data-bs-target="#{{ $t['target'] }}" aria-controls="{{ $t['target'] }}">
                                <span class="variants-trigger-icon">
                                    <i class="fa-solid {{ $t['icon'] }}" aria-hidden="true"></i>
                                </span>
                                <span class="variants-trigger-text">
                                    <span class="d-block fw-semibold">{{ $t['title'] }}</span>
                                    <span class="d-block small text-muted">{{ $t['desc'] }}</span>
                                </span>
                                <span class="variants-trigger-arrow">
                                    <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
                                </span>
                            </button>
                        </div>
                    </div>
                @endforeach

                <div class="sortable-card" data-card-id="shipping">
                    <div class="card p-4 mb-3">
                        <p class="fs-6 fw-semibold">Shipping</p>

                        <div class="status-toggle ship-toggle" role="radiogroup" aria-label="Product shipping type">
                            <label class="status-toggle-item">
                                <input type="radio" name="ship_type" value="physical" class="status-toggle-input" checked>
                                <span class="status-toggle-button">
                                    <i class="fa-solid fa-shirt" aria-hidden="true"></i> Physical product
                                </span>
                            </label>
                            <label class="status-toggle-item">
                                <input type="radio" name="ship_type" value="digital" class="status-toggle-input">
                                <span class="status-toggle-button">
                                    <i class="fa-solid fa-cloud-arrow-up" aria-hidden="true"></i> Digital product
                                </span>
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
                                <label class="form-label text-ink-3" for="lengthInput">Length</label>
                                <input type="number" min="0" inputmode="decimal" id="lengthInput"
                                    name="length" class="form-control" value="40">
                            </div>
                            <div class="form-group col-md-4">
                                <label class="form-label text-ink-3" for="widthInput">Width</label>
                                <input type="number" min="0" inputmode="decimal" id="widthInput" name="width"
                                    class="form-control" value="30">
                            </div>
                            <div class="form-group col-md-4">
                                <label class="form-label text-ink-3" for="heightInput">Height</label>
                                <input type="number" min="0" inputmode="decimal" id="heightInput"
                                    name="height" class="form-control" value="20">
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label text-ink-3" for="dimensionUnitSelect">Unit</label>
                                <select class="form-select" id="dimensionUnitSelect" name="dimension_unit">
                                    <option>Centimeter (cm)</option>
                                    <option>Meter (m)</option>
                                    <option>Inch (in)</option>
                                </select>
                            </div>
                        </div>

                        <div class="alert alert-primary mt-4 p-3 d-none" id="digitalShippingFields">
                            Digital products don't need weight or dimensions — customers get access right after
                            purchase, with nothing to ship.
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-4">
            <div id="col4SortArea">

                <div class="sortable-card" data-card-id="product-chart">
                    <div class="card p-4 mb-3">
                        <p class="fs-6 fw-semibold mb-1">Product Performance</p>
                        <div class="mb-2">
                            <span class="fs-4 fw-bold" id="perfCurrentValue">—</span>
                            <span class="small ms-1" id="perfChangeValue"></span>
                        </div>
                        <div class="perf-chart">
                            <canvas id="productPerformanceChart"></canvas>
                        </div>
                        <div class="text-muted small mt-2 d-none" id="perfErrorMsg">
                            Couldn't load performance data right now.
                        </div>
                    </div>
                </div>

                <div class="sortable-card" data-card-id="stock">
                    <div class="card p-4 mb-3">
                        <p class="fs-6 fw-semibold">Stock</p>
                        <div class="form-group col-12 px-0">
                            <label class="field-label" for="onHandStockInput">On hand stock</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="onHandStockInput" id="onHandStockInput"
                                    min="0" value="" placeholder="0">
                                <button type="button" class="btn btn-dark text-nowrap" id="reorderBtn">Reorder</button>
                            </div>
                            <div class="form-check ps-0">
                                <input class="form-check-input check-black" type="checkbox" id="continueSellingCheck"
                                    name="continueSellingCheck" checked>
                                <label class="form-check-label me-0" for="continueSellingCheck">
                                    Continue selling when out of stock
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="sortable-card" data-card-id="product-org">
                    <div class="card p-4 mb-3">
                        <p class="fs-6 fw-semibold">Product Organization</p>
                        <div class="card-body p-0">
                            <div class="form-group px-0">
                                <label for="sku" class="form-label">SKU</label>
                                <input type="text" class="form-control" name="sku" id="sku"
                                    value="{{ old('sku') }}">
                                @error('sku')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                                <span class="info-dot ms-1" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="custom made by me" aria-label="Info: custom made by me">i</span>
                            </div>

                            @foreach (['category' => 'Category', 'type' => 'Type', 'vendor' => 'Vendor', 'tags' => 'Tags'] as $field => $label)
                                <div class="form-group px-0">
                                    <label for="{{ $field }}" class="form-label">{{ $label }}</label>
                                    <select name="{{ $field }}" id="{{ $field }}" class="form-select"
                                        {{ $field === 'type' ? 'disabled' : '' }}>
                                        <option value=""></option>
                                    </select>
                                    @error($field)
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-md-12 mt-0">
            <div class="card p-4 mb-3 notes-card">
                <p class="fs-6 fw-semibold">Notes</p>
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

    <input type="hidden" name="product_id" id="productIdInput" value="{{ $product->uuid ?? '' }}">
    <input type="hidden" name="status" id="productStatusInput" value="draft">
    <div class="sticky-action-bar">
        <div class="sticky-action-bar-inner">
            <button type="button" class="btn btn-dark bg-dark-gradient" data-status="draft">
                <i class="fas fa-file-alt me-2"></i> Save as Draft
            </button>
            <button type="button" class="btn btn-secondary bg-secondary-gradient" data-status="scheduled">
                <i class="fas fa-calendar-alt me-2"></i> Schedule
            </button>
            <button type="button" class="btn btn-primary bg-primary-gradient" data-status="published">
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
                <p class="fs-6 fw-semibold">Variants</p>

                <div id="variantTypeRows">
                    <div class="row g-0 border p-3 mb-2 rounded-3 align-items-center variant-type-row">
                        <div class="col">
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <label class="field-label">Variant type</label>
                                    <select class="form-select variant-type-select" name="variant_type[]">
                                        <option value="Color">Color</option>
                                        <option value="SSD Size">SSD Size</option>
                                        <option value="RAM">RAM</option>
                                        <option value="Size">Size</option>
                                        <option value="Material">Material</option>
                                    </select>
                                </div>
                                <div class="col-md-9 form-group">
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
                        <div class="col-auto pt-4 ps-3">
                            <button type="button"
                                class="btn mt-2 d-flex py-2 px-1 justify-content-center rounded-3 variant-type-delete"
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
                <p class="fs-6 fw-semibold">Variants Table</p>

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
                            <div class="combo-img-picker border rounded d-flex align-items-center justify-content-center"
                                title="Set image for this combination" data-combo-image>
                                <i class="fa-regular fa-image combo-img-icon" aria-hidden="true"></i>
                                <img src="" alt="Variant combination image" data-combo-preview>
                                <span class="combo-img-overlay"><i class="fa-solid fa-pen" aria-hidden="true"></i></span>
                                <button type="button" class="combo-img-remove" data-combo-remove
                                    aria-label="Remove image" title="Remove image">
                                    <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                                </button>
                                <input type="hidden" name="variant_image_url[]" data-combo-value value="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="variant-pills mb-2 ps-2"></div>
                            <div class="row g-2">
                                <div class="col-md-4 form-group">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa-solid fa-barcode"
                                                aria-hidden="true"></i></span>
                                        <input type="text" class="form-control" placeholder="SKU"
                                            name="variant_sku[]">
                                    </div>
                                </div>
                                <div class="col-md-4 form-group">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa-solid fa-tag"
                                                aria-hidden="true"></i></span>
                                        <input type="text" class="form-control" placeholder="Price"
                                            name="variant_price[]">
                                    </div>
                                </div>
                                <div class="col-md-4 form-group">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa-solid fa-boxes-stacked"
                                                aria-hidden="true"></i></span>
                                        <input type="text" class="form-control" placeholder="Stock"
                                            name="variant_stock[]">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn d-flex py-2 px-1 mt-4 combo-row-delete"
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
            <div class="card p-4 mb-3">
                <p class="fs-6 fw-semibold">Upload</p>
                <div class="mm-dropzone" id="mediaLibDropzone">
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                    <div class="mm-drop-title">Drag and drop images here</div>
                    <div class="mm-drop-sub">or click to browse from your computer</div>
                </div>
                <input type="file" id="mediaLibFileInput" accept="image/*" multiple>
            </div>

            <div class="card p-4 mb-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <p class="fs-6 fw-semibold mb-0">Library</p>
                    <label class="ml-select-all d-flex align-items-center gap-2 mb-0" for="mediaSelectAll">
                        <input type="checkbox" class="form-check-input check-black m-0" id="mediaSelectAll">
                        <span>Select all</span>
                    </label>
                </div>
                <div class="ml-grid" id="mediaLibGrid"></div>
            </div>
        </div>

        <div class="offcanvas-footer">
            <span class="me-auto small text-muted align-self-center" id="mediaSelectedCount">0 selected</span>
            <button type="button" class="btn btn-outline-danger" id="mediaDeleteSelectedBtn" disabled>
                Delete selected
            </button>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Close</button>
        </div>
    </div>

    <div class="alert-overlay" id="lightboxOverlay">
        <div class="alert-popup lightbox-popup">
            <button type="button" class="alert-btn-close" id="lightboxClose" aria-label="Close">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <img src="" alt="" id="lightboxImage">
        </div>
    </div>

    <div class="alert-overlay" id="mediaModalOverlay">
        <div class="alert-popup media-modal">
            <div class="media-modal-header">
                <div class="media-modal-title">Add combination image</div>
                <button type="button" class="alert-btn-close" id="mediaModalClose" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div class="nav nav-tabs media-modal-tabs" id="mediaModalTabs">
                <button type="button" class="nav-link active" data-tab="upload">Upload</button>
                <button type="button" class="nav-link" data-tab="library">Select from library</button>
            </div>

            <div class="media-modal-body">
                <div class="mm-panel active" id="mmUploadPanel">
                    <div class="mm-dropzone" id="mmDropzone">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                        <div class="mm-drop-title">Drag and drop an image here</div>
                        <div class="mm-drop-sub">or click to browse from your computer</div>
                    </div>
                    <input type="file" id="mmFileInput" accept="image/*">
                </div>

                <div class="mm-panel" id="mmLibraryPanel">
                    <div class="mm-library-toolbar">
                        <div class="search-box">
                            <i class="fa-solid fa-magnifying-glass s-icon"></i>
                            <input type="text" id="mmLibrarySearch" placeholder="Search image library">
                        </div>
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
        #content {
            padding-bottom: 0;
        }

        .card {
            box-shadow: 1px 4px 15px 0 rgb(0 0 0 / 15%);
            border-radius: 5px;
        }

        .check-black[type=checkbox] {
            width: 1.1rem;
            height: 1.1rem;
        }

        .info-dot {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #212529;
            color: #fff;
            font-size: 11px;
            cursor: help;
        }

        .perf-chart {
            height: 170px;
        }

        #summernote p {
            margin-bottom: 0;
        }

        input[type=file] {
            display: none;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice.select2-selection__choice {
            display: inline-flex;
            align-items: center;
            background-color: #1a1a1a;
            border: 1px solid #1a1a1a;
            border-radius: 6px;
            padding: 0 0 0 5px;
            margin: 4px 0 0 6px;
            font-size: 14px;
            font-weight: 500;
            line-height: 24px;
            color: #fff;
            transition: background-color .15s ease, border-color .15s ease;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice.select2-selection__choice:hover {
            background-color: #333;
            border-color: #333;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__display.select2-selection__choice__display {
            padding: 0 6px 0 4px;
            color: inherit;
            font-weight: 500;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove.select2-selection__choice__remove {
            position: static;
            order: 2;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 5px;
            border: 0;
            border-left: 1px solid rgba(255, 255, 255, .25);
            border-radius: 0 6px 6px 0;
            background: transparent;
            color: #fff;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove.select2-selection__choice__remove:hover,
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove.select2-selection__choice__remove:focus {
            background-color: #fff;
            color: #000;
            outline: none;
        }

        .status-toggle {
            padding: 5px;
            box-shadow: 0 1px 2px rgba(10, 74, 110, 0.03), 0 8px 20px -12px rgba(10, 74, 110, 0.18);
        }

        .ship-toggle .status-toggle-button {
            padding-block: 11px;
        }

        .ship-toggle .status-toggle-input:checked+.status-toggle-button {
            background: #232133;
            color: #fff;
            opacity: 1;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .25);
        }

        .sortable-card {
            position: relative;
        }

        .card-move-wrap {
            position: absolute;
            top: 14px;
            right: 14px;
            z-index: 5;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .card-move-wrap--inline {
            position: static;
            flex-shrink: 0;
            justify-content: center;
            padding: 0 12px;
            border-left: 1px solid #eee;
        }

        .card-move-btn {
            width: 24px;
            height: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 0;
            border-radius: 5px;
            background: linear-gradient(45deg, #0000001a, transparent);
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
            box-shadow: 1px 4px 15px 0 rgb(0 0 0 / 15%);
            transition: box-shadow .15s ease;
        }

        .variants-trigger-card:hover {
            box-shadow: 0 6px 20px rgb(0 0 0 / 18%);
        }

        .variants-trigger-btn {
            display: flex;
            align-items: center;
            gap: 14px;
            flex: 1;
            min-width: 0;
            padding: 18px 20px;
            border: 0;
            border-radius: 8px;
            background: transparent;
            text-align: left;
        }

        .variants-trigger-icon {
            width: 42px;
            height: 42px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background: #111;
            color: #fff;
            font-size: 17px;
        }

        .variants-trigger-text {
            flex: 1;
        }

        .variants-trigger-arrow {
            color: #999;
        }

        #variantsModal,
        #mediaLibraryModal {
            --bs-offcanvas-width: calc(100vw - var(--sidebar-w, 0px));
            max-width: 100vw;
        }

        html.sb-collapsed #variantsModal,
        html.sb-collapsed #mediaLibraryModal {
            --bs-offcanvas-width: calc(100vw - var(--sidebar-collapsed));
        }

        #variantsModal .offcanvas-body,
        #mediaLibraryModal .offcanvas-body {
            background: #f8f9fa;
            padding: 24px max(24px, calc((100% - 1200px) / 2));
        }

        #variantsModal .offcanvas-header,
        #mediaLibraryModal .offcanvas-header,
        .offcanvas-footer {
            background: #fff;
            padding-left: 24px;
            padding-right: 24px;
        }

        #variantsModal .offcanvas-header,
        #mediaLibraryModal .offcanvas-header {
            border-bottom: 1px solid #dee2e6;
        }

        .offcanvas-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding-top: 16px;
            padding-bottom: 16px;
            border-top: 1px solid #dee2e6;
            flex-shrink: 0;
        }

        .variant-type-row,
        .combo-row {
            background: #fff;
        }

        .variant-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .variant-pill {
            padding: 3px 10px;
            border: 1px solid #88888820;
            border-radius: 5px;
            font-size: 13px;
            font-weight: 600;
            line-height: normal;
            letter-spacing: .3px;
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

        .combo-img-picker {
            position: relative;
            width: 64px;
            height: 64px;
            flex-shrink: 0;
            overflow: hidden;
            background: #ececec;
            cursor: pointer;
        }

        .combo-img-icon {
            font-size: 26px;
            color: #343c54;
        }

        .combo-img-picker img {
            display: none;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .combo-img-picker.has-image img {
            display: block;
        }

        .combo-img-picker.has-image .combo-img-icon {
            display: none;
        }

        .combo-img-overlay {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(17, 17, 17, .45);
            color: #fff;
            font-size: 14px;
            opacity: 0;
            transition: opacity .15s ease;
        }

        .combo-img-picker.has-image:hover .combo-img-overlay {
            opacity: 1;
        }

        .combo-img-remove {
            position: absolute;
            top: 3px;
            right: 3px;
            z-index: 2;
            display: none;
            align-items: center;
            justify-content: center;
            width: 18px;
            height: 18px;
            border: 0;
            border-radius: 50%;
            background: rgba(17, 17, 17, .7);
            color: #fff;
            font-size: 9px;
        }

        .combo-img-picker.has-image .combo-img-remove {
            display: flex;
        }

        #mediaLibraryModal {
            --ml-accent: #111;
            --ml-accent-ring: rgba(17, 17, 17, .15);
        }

        #mediaLibraryModal .mm-dropzone {
            padding: 28px 20px;
        }

        .ml-select-all {
            cursor: pointer;
            font-size: 13px;
            font-weight: 500;
            color: #3c4350;
        }

        .ml-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 16px 12px;
        }

        .ml-empty {
            grid-column: 1 / -1;
            padding: 24px 0;
            text-align: center;
            font-size: 13px;
            color: #6c757d;
        }

        .ml-item {
            display: flex;
            flex-direction: column;
            gap: 6px;
            min-width: 0;
        }

        .ml-thumb {
            position: relative;
            aspect-ratio: 1 / 1.1;
            overflow: hidden;
            border: 2px solid transparent;
            border-radius: 8px;
            background: #e9ecf1;
            cursor: pointer;
            transition: border-color .15s ease, box-shadow .15s ease;
        }

        .ml-thumb img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .25s ease;
        }

        .ml-item:hover .ml-thumb img {
            transform: scale(1.05);
        }

        .ml-item.is-selected .ml-thumb {
            border-color: var(--ml-accent);
            box-shadow: 0 0 0 2px var(--ml-accent-ring);
        }

        .ml-name {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            font-size: 12px;
            line-height: 1.3;
            color: #3c4350;
            word-break: break-word;
        }

        .ml-check,
        .ml-actions {
            position: absolute;
            top: 6px;
            opacity: 0;
            transition: opacity .15s ease;
        }

        .ml-item:hover .ml-check,
        .ml-item:hover .ml-actions,
        .ml-item.is-selected .ml-check,
        .ml-item.is-selected .ml-actions,
        .ml-check:focus-within,
        .ml-actions:focus-within {
            opacity: 1;
        }

        .ml-check {
            left: 6px;
            width: 20px;
            height: 20px;
            margin: 0;
            cursor: pointer;
        }

        .ml-check input {
            position: absolute;
            inset: 0;
            z-index: 1;
            width: 100%;
            height: 100%;
            margin: 0;
            opacity: 0;
            cursor: pointer;
        }

        .ml-check span {
            display: block;
            width: 20px;
            height: 20px;
            border: 1px solid #c4cad4;
            border-radius: 4px;
            background: #fff;
            box-shadow: 0 1px 2px rgba(0, 0, 0, .2);
        }

        .ml-check input:checked+span {
            border-color: var(--ml-accent);
            background: var(--ml-accent) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath fill='none' stroke='%23fff' stroke-width='2.2' stroke-linecap='round' stroke-linejoin='round' d='M3.5 8.5l3 3 6-6.5'/%3E%3C/svg%3E") center / 14px no-repeat;
        }

        .ml-check input:focus-visible+span {
            outline: 2px solid var(--ml-accent);
            outline-offset: 2px;
        }

        .ml-actions {
            right: 6px;
            display: flex;
            gap: 4px;
        }

        .ml-actions button {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 22px;
            height: 22px;
            padding: 0;
            border: 0;
            border-radius: 50%;
            background: #fff;
            color: #444;
            font-size: 10px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, .25);
            cursor: pointer;
        }

        .ml-actions button:hover {
            background: #f0f2f6;
        }

        .ml-actions button[data-act="delete"]:hover {
            background: #fde8e8;
            color: #c62828;
        }

        .mm-dropzone {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 52px 20px;
            border: 1.5px dashed #d5d4e4;
            border-radius: 14px;
            text-align: center;
            color: #6c757d;
            cursor: pointer;
            transition: border-color .15s ease, background .15s ease;
        }

        .mm-dropzone:hover,
        .mm-dropzone.drag-over {
            border-color: #111;
            background: #f1f1f1;
            color: #111;
        }

        .mm-dropzone i {
            margin-bottom: 12px;
            font-size: 30px;
        }

        .mm-drop-title {
            margin-bottom: 4px;
            font-size: 14px;
            font-weight: 600;
            color: #212529;
        }

        .mm-drop-sub {
            font-size: 12.5px;
            color: #6c757d;
        }

        .lightbox-popup {
            width: auto;
            max-width: 90vw;
            padding: 0;
            background: none;
            border: 0;
        }

        .lightbox-popup img {
            display: block;
            max-width: 90vw;
            max-height: 90vh;
            border-radius: 10px;
        }

        .media-modal {
            display: flex;
            flex-direction: column;
            max-width: 620px;
            max-height: 84vh;
            padding: 0;
            text-align: left;
        }

        .media-modal-header,
        .media-modal-footer {
            display: flex;
            flex-shrink: 0;
            padding: 16px 22px;
        }

        .media-modal-header {
            align-items: center;
            padding-right: 56px;
            border-bottom: 1px solid #dee2e6;
        }

        .media-modal-footer {
            justify-content: flex-end;
            gap: 10px;
            border-top: 1px solid #dee2e6;
        }

        .media-modal-title {
            font-size: 15.5px;
            font-weight: 600;
        }

        .media-modal-tabs {
            flex-shrink: 0;
            padding: 0 22px;
        }

        .media-modal-body {
            flex: 1;
            min-height: 320px;
            padding: 22px;
            overflow-y: auto;
        }

        .mm-panel {
            display: none;
        }

        .mm-panel.active {
            display: block;
        }

        .mm-library-toolbar {
            margin-bottom: 16px;
        }

        .mm-library-toolbar .search-box {
            max-width: none;
        }

        .mm-library-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
        }

        @media (max-width: 575px) {
            .mm-library-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        .mm-library-item {
            position: relative;
            aspect-ratio: 1 / 1;
            overflow: hidden;
            border: 2px solid transparent;
            border-radius: 12px;
            background: #efefef;
            cursor: pointer;
        }

        .mm-library-item.selected {
            border-color: #111;
        }

        .mm-library-item img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .mm-library-item .mm-check {
            position: absolute;
            top: 7px;
            right: 7px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 20px;
            border: 1.5px solid #d5d4e4;
            border-radius: 50%;
            background: rgba(255, 255, 255, .9);
            font-size: 10px;
            color: transparent;
            transition: all .12s ease;
        }

        .mm-library-item.selected .mm-check {
            border-color: #111;
            background: #111;
            color: #fff;
        }

        .mm-library-item .mm-name {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            padding: 12px 8px 6px;
            overflow: hidden;
            background: linear-gradient(0deg, rgba(0, 0, 0, .55), transparent);
            font-size: 10.5px;
            color: #fff;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .sticky-action-bar {
            position: sticky;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 99;
            margin-top: 1.5rem;
            border-top: 1px solid #e5e5e5;
            background: #fff;
            box-shadow: 0 -6px 20px rgb(0 0 0 / 8%);
        }

        .sticky-action-bar-inner {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding: 14px 20px;
            border: 1px solid #00000035;
            border-radius: 5px 5px 0 0;
            box-shadow: 0 0 10px #00000020;
        }
    </style>
@endpush

@push('js')
    <script>
        $(function() {
            'use strict';

            const $doc = $(document);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            const MEDIA_UPLOAD_URL = "{{ route('admin.products.add.media') }}";
            const MEDIA_UPLOAD_URL_WITH_PRODUCT = "{{ route('admin.products.add.media', ['product' => '__ID__']) }}";
            let currentProductId = @json($product->uuid ?? null);

            const mediaUploadUrl = () => currentProductId ?
                MEDIA_UPLOAD_URL_WITH_PRODUCT.replace('__ID__', currentProductId) :
                MEDIA_UPLOAD_URL;

            const MEDIA_LIBRARY = [];

            const readImageFile = (file, done) => {
                const reader = new FileReader();
                reader.onload = ev => done(ev.target.result);
                reader.readAsDataURL(file);
            };

            const imageFiles = list => Array.from(list || []).filter(f => f.type.startsWith('image/'));

            function bindDropzone($zone, $input, onFiles) {
                $zone.on('click', () => $input.trigger('click'))
                    .on('dragover', function(e) {
                        e.preventDefault();
                        $(this).addClass('drag-over');
                    })
                    .on('dragleave', function() {
                        $(this).removeClass('drag-over');
                    })
                    .on('drop', function(e) {
                        e.preventDefault();
                        $(this).removeClass('drag-over');
                        onFiles(e.originalEvent.dataTransfer.files);
                    });

                $input.on('change', function() {
                    onFiles(this.files);
                    $(this).val('');
                });
            }

            $('input[name="ship_type"]').on('change', function() {
                $('#shippingDetailsBox').toggleClass('d-none', this.value === 'digital');
                $('#digitalShippingFields').toggleClass('d-none', this.value === 'physical');
            }).filter(':checked').trigger('change');

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

            $('#submitNoteBtn').on('click', function() {
                const $note = $('#summernote');
                if ($note.summernote('isEmpty')) return;

                const $tmp = $('<div>').html($note.summernote('code'));
                $tmp.find('img').each(function() {
                    $(this).replaceWith(
                        $('<a>', {
                            href: $(this).attr('src'),
                            target: '_blank',
                            rel: 'noopener noreferrer',
                            class: 'text-secondary'
                        }).html('<i class="fa-solid fa-image"></i> View image')
                    );
                });

                $('#summernote-result').html($tmp.html());
                $note.summernote('reset');
            });

            $('[data-status]').on('click', function() {
                $('#productStatusInput').val($(this).data('status'));
            });

            (function() {
                const canvas = document.getElementById('productPerformanceChart');
                if (!canvas) return;

                const fmtDay = d => d.toLocaleDateString(undefined, {
                    month: 'short',
                    day: 'numeric'
                });

                const fetchSeries = () => fetch(
                        'https://api.coingecko.com/api/v3/coins/bitcoin/market_chart?vs_currency=usd&days=14&interval=daily'
                    )
                    .then(res => {
                        if (!res.ok) throw new Error('Request failed: ' + res.status);
                        return res.json();
                    })
                    .then(data => {
                        const points = data.prices || [];
                        if (!points.length) throw new Error('Empty series');
                        return {
                            labels: points.map(p => fmtDay(new Date(p[0]))),
                            values: points.map(p => p[1])
                        };
                    });

                function fallbackSeries() {
                    const labels = [];
                    const values = [];
                    let value = 800 + Math.random() * 200;
                    for (let i = 13; i >= 0; i--) {
                        const d = new Date();
                        d.setDate(d.getDate() - i);
                        value = Math.max(50, value + (Math.random() - 0.45) * 40);
                        labels.push(fmtDay(d));
                        values.push(Math.round(value * 100) / 100);
                    }
                    return {
                        labels,
                        values
                    };
                }

                function render(series) {
                    const first = series.values[0];
                    const last = series.values[series.values.length - 1];
                    const pct = first ? ((last - first) / first) * 100 : 0;

                    $('#perfCurrentValue').text('$' + last.toLocaleString(undefined, {
                        maximumFractionDigits: 2
                    }));
                    $('#perfChangeValue')
                        .text((pct >= 0 ? '+' : '') + pct.toFixed(2) + '%')
                        .css('color', pct >= 0 ? '#0f9d58' : '#d93025');

                    const tickFont = {
                        font: {
                            size: 10
                        }
                    };

                    new Chart(canvas, {
                        type: 'line',
                        data: {
                            labels: series.labels,
                            datasets: [{
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
                                        ...tickFont
                                    }
                                },
                                y: {
                                    grid: {
                                        color: '#f1f1f1'
                                    },
                                    ticks: tickFont
                                }
                            }
                        }
                    });
                }

                fetchSeries()
                    .catch(fallbackSeries)
                    .then(series => {
                        if (typeof Chart === 'undefined') throw new Error('Chart.js not loaded');
                        render(series);
                    })
                    .catch(() => $('#perfErrorMsg').removeClass('d-none'));
            })();

            (function() {
                const MOVE_BUTTONS =
                    '<button type="button" class="card-move-btn" data-move="up" title="Move up" aria-label="Move card up"><i class="fa-solid fa-caret-up" aria-hidden="true"></i></button>' +
                    '<button type="button" class="card-move-btn" data-move="down" title="Move down" aria-label="Move card down"><i class="fa-solid fa-caret-down" aria-hidden="true"></i></button>';

                const store = {
                    save(key, ids) {
                        const value = JSON.stringify(ids);
                        document.cookie = key + '=' + encodeURIComponent(value) +
                            ';path=/;max-age=31536000;SameSite=Lax';
                        try {
                            localStorage.setItem(key, value);
                        } catch (e) {}
                    },
                    load(key) {
                        try {
                            const match = document.cookie.match(new RegExp('(?:^|; )' + key + '=([^;]*)'));
                            if (match) return JSON.parse(decodeURIComponent(match[1]));
                            return JSON.parse(localStorage.getItem(key));
                        } catch (e) {
                            return null;
                        }
                    }
                };

                function addMoveButtons(card) {
                    const wrap = document.createElement('div');
                    wrap.className = 'card-move-wrap';
                    wrap.innerHTML = MOVE_BUTTONS;

                    const inline = card.querySelector('.variants-trigger-card');
                    if (inline) {
                        wrap.classList.add('card-move-wrap--inline');
                        inline.appendChild(wrap);
                    } else {
                        card.prepend(wrap);
                    }
                }

                function initGroup(containerId, storageKey) {
                    const box = document.getElementById(containerId);
                    if (!box) return;

                    const cards = () => Array.from(box.querySelectorAll(':scope > .sortable-card'));
                    cards().forEach(addMoveButtons);

                    (store.load(storageKey) || []).forEach(id => {
                        const el = box.querySelector(':scope > .sortable-card[data-card-id="' + id + '"]');
                        if (el) box.appendChild(el);
                    });

                    const refresh = () => cards().forEach((card, i, all) => {
                        card.querySelector('[data-move="up"]').disabled = i === 0;
                        card.querySelector('[data-move="down"]').disabled = i === all.length - 1;
                    });

                    box.addEventListener('click', e => {
                        const btn = e.target.closest('[data-move]');
                        if (!btn || btn.disabled) return;

                        const card = btn.closest('.sortable-card');
                        const up = btn.dataset.move === 'up';
                        const sibling = up ? card.previousElementSibling : card.nextElementSibling;
                        if (!sibling) return;

                        box.insertBefore(up ? card : sibling, up ? sibling : card);
                        refresh();
                        store.save(storageKey, cards().map(c => c.dataset.cardId));
                    });

                    refresh();
                }

                initGroup('col8SortArea', 'productFormCardOrder_col8');
                initGroup('col4SortArea', 'productFormCardOrder_col4');
            })();

            (function() {
                const $typeRows = $('#variantTypeRows');
                const typeRowTemplate = $typeRows.find('.variant-type-row').first().clone();
                const $comboRows = $('#generatedComboRows');
                const $comboWrap = $('#generatedVariantsWrap');
                const comboRowTemplate = $('#comboRowTemplate .combo-row').first();

                const comboRow = pillsHtml => comboRowTemplate.clone().find('.variant-pills')
                    .html(pillsHtml || '<span class="variant-pill">New combination</span>').end();

                $('#addVariantTypeBtn').on('click', function() {
                    const $row = typeRowTemplate.clone();
                    $row.find('.variant-type-select').prop('selectedIndex', 0);
                    $row.find('.variant-value-select').val([]);
                    $typeRows.append($row);
                });

                $doc.on('click', '.variant-type-delete', function() {
                    if ($typeRows.find('.variant-type-row').length > 1) {
                        $(this).closest('.variant-type-row').remove();
                    }
                });

                $('#generateVariationsBtn').on('click', function() {
                    const groups = $typeRows.find('.variant-type-row').map(function() {
                        const typeEl = $(this).find('.variant-type-select')[0];
                        const valueEl = $(this).find('.variant-value-select')[0];
                        return {
                            type: typeEl.options[typeEl.selectedIndex].text,
                            values: Array.from(valueEl.selectedOptions).map(o => o.text)
                        };
                    }).get().filter(g => g.values.length);

                    if (!groups.length) return;

                    const combos = groups.reduce(
                        (acc, g) => acc.flatMap(c => g.values.map(v => c.concat({
                            type: g.type,
                            value: v
                        }))), [
                            []
                        ]
                    );

                    $comboRows.empty().append(combos.map(combo => {
                        const pills = combo.map(c =>
                            $('<span class="variant-pill"></span>').text(c.type + ': ' + c.value)[0]
                            .outerHTML
                        ).join('');
                        return comboRow(pills);
                    }));
                    $comboWrap.removeClass('d-none');
                });

                $('#addComboRowBtn').on('click', function() {
                    $comboRows.append(comboRow());
                    $comboWrap.removeClass('d-none');
                });

                $doc.on('click', '.combo-row-delete', function() {
                    $(this).closest('.combo-row').remove();
                });
            })();

            (function() {
                const $grid = $('#mediaLibGrid');
                const $selectAll = $('#mediaSelectAll');
                const $count = $('#mediaSelectedCount');
                const $deleteSelected = $('#mediaDeleteSelectedBtn');
                const selected = new Set();

                const findItem = id => MEDIA_LIBRARY.find(i => i.id === id);

                function removeItem(id) {
                    const idx = MEDIA_LIBRARY.findIndex(i => i.id === id);
                    if (idx > -1) MEDIA_LIBRARY.splice(idx, 1);
                    selected.delete(id);
                }

                function syncToolbar() {
                    const total = MEDIA_LIBRARY.length;
                    $count.text(selected.size + ' selected');
                    $deleteSelected.prop('disabled', !selected.size);
                    $selectAll
                        .prop('disabled', !total)
                        .prop('checked', total > 0 && selected.size === total)
                        .prop('indeterminate', selected.size > 0 && selected.size < total);
                }

                function buildItem(item) {
                    const isSelected = selected.has(item.id);
                    const $thumb = $('<div class="ml-thumb"></div>').append(
                        $('<img loading="lazy">').attr({
                            src: item.url,
                            alt: item.name
                        }),
                        $('<label class="ml-check"></label>')
                        .attr('aria-label', 'Select ' + item.name)
                        .append($('<input type="checkbox">').prop('checked', isSelected), '<span></span>'),
                        $('<div class="ml-actions"></div>').append(
                            $('<button type="button" data-act="edit" title="Rename"><i class="fa-solid fa-pen" aria-hidden="true"></i></button>')
                            .attr('aria-label', 'Rename ' + item.name),
                            $('<button type="button" data-act="delete" title="Delete"><i class="fa-solid fa-xmark" aria-hidden="true"></i></button>')
                            .attr('aria-label', 'Delete ' + item.name)
                        )
                    );

                    return $('<div class="ml-item"></div>')
                        .attr('data-id', item.id)
                        .toggleClass('is-selected', isSelected)
                        .append($thumb, $('<span class="ml-name"></span>').text(item.name).attr('title', item.name));
                }

                function renderGrid() {
                    $grid.empty().append(
                        MEDIA_LIBRARY.length ?
                        MEDIA_LIBRARY.map(buildItem) :
                        '<div class="ml-empty">No images yet. Upload some above.</div>'
                    );
                    syncToolbar();
                }

                function uploadFiles(files) {
                    const queue = imageFiles(files);

                    const uploadNext = () => {
                        const file = queue.shift();
                        if (!file) return;

                        const fd = new FormData();
                        fd.append('media', file);

                        $.ajax({
                            url: mediaUploadUrl(),
                            method: 'POST',
                            data: fd,
                            processData: false,
                            contentType: false
                        }).done(res => {
                            currentProductId = res.product_id;
                            $('#productIdInput').val(res.product_id);
                            MEDIA_LIBRARY.unshift({
                                id: String(res.media.id),
                                name: res.media.name || file.name,
                                url: res.media.url
                            });
                            renderGrid();
                        }).fail(xhr => {
                            console.error(xhr.status, xhr.responseText);
                            alert('Upload failed: ' + file.name);
                        }).always(uploadNext);
                    };

                    uploadNext();
                }

                bindDropzone($('#mediaLibDropzone'), $('#mediaLibFileInput'), uploadFiles);

                $grid.on('change', '.ml-check input', function() {
                    const $item = $(this).closest('.ml-item');
                    const id = $item.attr('data-id');
                    this.checked ? selected.add(id) : selected.delete(id);
                    $item.toggleClass('is-selected', this.checked);
                    syncToolbar();
                });

                $selectAll.on('change', function() {
                    selected.clear();
                    if (this.checked) MEDIA_LIBRARY.forEach(i => selected.add(i.id));
                    renderGrid();
                });

                $grid.on('click', '.ml-item', function(e) {
                    const id = $(this).attr('data-id');
                    const item = findItem(id);
                    if (!item) return;

                    const $action = $(e.target).closest('[data-act]');
                    if ($action.length) {
                        if ($action.attr('data-act') === 'delete') {
                            removeItem(id);
                        } else {
                            const name = window.prompt('Rename image', item.name);
                            if (!name || !name.trim()) return;
                            item.name = name.trim();
                        }
                        renderGrid();
                        return;
                    }

                    if ($(e.target).closest('.ml-check').length || !$(e.target).closest('.ml-thumb').length) return;
                    $('#lightboxImage').attr('src', item.url);
                    $('#lightboxOverlay').addClass('open');
                });

                $deleteSelected.on('click', function() {
                    const n = selected.size;
                    if (!n || !window.confirm('Delete ' + n + ' selected image' + (n > 1 ? 's' : '') + '?')) return;
                    Array.from(selected).forEach(removeItem);
                    renderGrid();
                });

                $('#lightboxClose').on('click', function() {
                    $('#lightboxOverlay').removeClass('open');
                    $('#lightboxImage').attr('src', '');
                });

                $('#lightboxOverlay').on('click', function(e) {
                    if (e.target === this) $('#lightboxClose').trigger('click');
                });

                renderGrid();
            })();

            (function() {
                const $overlay = $('#mediaModalOverlay');
                const $addBtn = $('#mediaModalAdd');
                const $search = $('#mmLibrarySearch');
                const $grid = $('#mmLibraryGrid');
                const $tabs = $('#mediaModalTabs .nav-link');
                const $panels = $('.mm-panel');
                const $uploadPanel = $('#mmUploadPanel');
                let selectedId = null;
                let $target = null;

                function renderLibrary() {
                    const q = $search.val().trim().toLowerCase();

                    $grid.empty().append(
                        MEDIA_LIBRARY
                        .filter(item => !q || item.name.toLowerCase().includes(q))
                        .map(item => $('<div class="mm-library-item"></div>')
                            .toggleClass('selected', selectedId === item.id)
                            .attr('data-lib-id', item.id)
                            .append(
                                $('<img>').attr({
                                    src: item.url,
                                    alt: item.name
                                }),
                                '<span class="mm-check"><i class="fa-solid fa-check"></i></span>',
                                $('<span class="mm-name"></span>').text(item.name)
                            ))
                    );
                }

                const updateAddButton = () =>
                    $addBtn.prop('disabled', $uploadPanel.hasClass('active') || !selectedId);

                function showTab(tab) {
                    $tabs.removeClass('active').filter('[data-tab="' + tab + '"]').addClass('active');
                    $panels.removeClass('active');
                    $(tab === 'upload' ? '#mmUploadPanel' : '#mmLibraryPanel').addClass('active');
                    updateAddButton();
                }

                function open($picker) {
                    $target = $picker;
                    selectedId = null;
                    $search.val('');
                    renderLibrary();
                    showTab('upload');
                    $overlay.addClass('open');
                }

                function close() {
                    $overlay.removeClass('open');
                    $target = null;
                }

                function setImage(url) {
                    if (!$target) return;
                    $target.addClass('has-image');
                    $target.find('[data-combo-preview]').attr('src', url);
                    $target.find('[data-combo-value]').val(url);
                }

                $doc.on('click', '[data-combo-image]', function(e) {
                    e.preventDefault();
                    open($(this));
                });

                $doc.on('click', '[data-combo-remove]', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const $picker = $(this).closest('[data-combo-image]');
                    $picker.removeClass('has-image');
                    $picker.find('[data-combo-preview]').attr('src', '');
                    $picker.find('[data-combo-value]').val('');
                });

                $('#mediaModalClose, #mediaModalCancel').on('click', close);

                $overlay.on('click', function(e) {
                    if (e.target === this) close();
                });

                $('#mediaModalTabs').on('click', '.nav-link', function() {
                    showTab($(this).data('tab'));
                });

                bindDropzone($('#mmDropzone'), $('#mmFileInput'), files => {
                    const file = imageFiles(files)[0];
                    if (!file) return;
                    readImageFile(file, url => {
                        setImage(url);
                        close();
                    });
                });

                $search.on('input', renderLibrary);

                $grid.on('click', '.mm-library-item', function() {
                    selectedId = $(this).attr('data-lib-id');
                    renderLibrary();
                    updateAddButton();
                });

                $addBtn.on('click', function() {
                    const item = MEDIA_LIBRARY.find(i => i.id === selectedId);
                    if (item) setImage(item.url);
                    close();
                });
            })();

            $doc.on('keydown', function(e) {
                if (e.key === 'Escape') {
                    $('.alert-overlay.open .alert-btn-close').first().trigger('click');
                }
            });
        });
    </script>
@endpush