<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    
    @include('layouts.seo')
	
    @include('layouts.style')
</head>
<body>
    <!-- READING POSITION INDICATOR -->
    <progress value="0" id="eskimo-progress-bar">
        <span class="eskimo-progress-container">
            <span class="eskimo-progress-bar"></span>
        </span>
    </progress>
    <!-- SITE WRAPPER -->
    <div id="eskimo-site-wrapper">
        <!-- MAIN CONTAINER -->
        <main id="eskimo-main-container">
            <div class="container">
                <!-- SIDEBAR -->
                @include('layouts.header')
                <!-- TOP ICONS -->
                <ul class="eskimo-top-icons">
                    <li id="eskimo-panel-icon">
                        <a href="#eskimo-panel" class="eskimo-panel-open"><i class="fa fa-bars"></i></a>
                    </li>
                    <li id="eskimo-search-icon">
                        <a id="eskimo-open-search" href="#"><i class="fa fa-search"></i></a>
                    </li>
                </ul>

                @yield('content')
            </div>
        </main>
        <!-- FOOTER -->
        @include('layouts.footer')
    </div>
    <!-- GO TO TOP BUTTON -->
    <a id="eskimo-gototop" href="#"><i class="fa fa-chevron-up"></i></a>
    <!-- SLIDE PANEL OVERLAY -->
    <div id="eskimo-overlay"></div>
    <!-- SLIDE PANEL -->
    @include('layouts.sidebar')
    <!-- FULLSCREEN SEARCH -->
    <div id="eskimo-fullscreen-search">
        <div id="eskimo-fullscreen-search-content">
            <a href="#" id="eskimo-close-search" title="Close Search (Esc)"><i class="fa fa-times"></i></a>
            <form role="search" method="GET" action="{{ route('search.posts') }}" class="eskimo-lg-form eskimo-advanced-search-form" id="fullscreen-search-form">
                <!-- Search Modal Header -->
                <div class="search-modal-header text-center mb-4">
                    <span class="search-badge mb-2"><i class="fa fa-search"></i> Smart Search</span>
                    <h2 class="search-headline">Find posts, galleries & videos</h2>
                    <p class="search-subheadline text-muted">Select a collection or search across everything</p>
                </div>

                <!-- Content Type Selector Pills -->
                <div class="search-type-selector mb-3 text-center">
                    <input type="hidden" name="type" id="fullscreen-search-type" value="{{ request('type', 'all') }}" />
                    <div class="search-type-pills">
                        <button type="button" class="type-pill-btn {{ request('type', 'all') === 'all' ? 'active' : '' }}" data-type="all">
                            <i class="fa fa-th-large"></i> <span>All</span>
                        </button>
                        <button type="button" class="type-pill-btn {{ request('type') === 'posts' ? 'active' : '' }}" data-type="posts">
                            <i class="fa fa-file-text-o"></i> <span>Posts & Quotes</span>
                        </button>
                        <button type="button" class="type-pill-btn {{ request('type') === 'galleries' ? 'active' : '' }}" data-type="galleries">
                            <i class="fa fa-picture-o"></i> <span>Galleries</span>
                        </button>
                        <button type="button" class="type-pill-btn {{ request('type') === 'videos' ? 'active' : '' }}" data-type="videos">
                            <i class="fa fa-play-circle-o"></i> <span>Videos</span>
                        </button>
                    </div>
                </div>

                <!-- Search Input Group -->
                <div class="search-bar-container">
                    <div class="input-group search-input-group">
                        <div class="input-group-prepend search-icon-prepend">
                            <span class="input-group-text"><i class="fa fa-search"></i></span>
                        </div>
                        <input type="text"
                               class="form-control form-control-lg search-main-input"
                               id="fullscreen-search-input"
                               placeholder="Search across all collections..."
                               name="search"
                               value="{{ request('search') }}"
                               autocomplete="off"
                               required />
                        <button type="button" id="search-clear-input" class="search-clear-btn" title="Clear input" style="display: {{ request('search') ? 'block' : 'none' }};">&times;</button>
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-search-submit">
                                <span>Search</span>
                                <i class="fa fa-arrow-right ml-1"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Quick Suggested Tags & Helper Text -->
                <div class="search-quick-tags mt-3 text-center">
                    <span class="quick-tags-label text-muted"><i class="fa fa-lightbulb-o"></i> Quick Search:</span>
                    <button type="button" class="quick-tag-chip" data-keyword="Quotes" data-type="posts">Quotes</button>
                    <button type="button" class="quick-tag-chip" data-keyword="Love" data-type="all">Love</button>
                    <button type="button" class="quick-tag-chip" data-keyword="Life" data-type="all">Life</button>
                    <button type="button" class="quick-tag-chip" data-keyword="Inspirational" data-type="posts">Inspirational</button>
                    <button type="button" class="quick-tag-chip" data-keyword="Nature" data-type="galleries">Galleries</button>
                    <button type="button" class="quick-tag-chip" data-keyword="Video" data-type="videos">Videos</button>
                </div>

                <div class="search-helper-hint text-center mt-3">
                    <small class="text-muted"><kbd>ESC</kbd> to close &bull; <kbd>Enter</kbd> to search</small>
                </div>
            </form>
        </div>
    </div>

    <!-- Search Modal Enhanced Styles -->
    <style>
    #eskimo-fullscreen-search {
        background-color: rgba(248, 249, 250, 0.96) !important;
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }

    #eskimo-close-search {
        border-radius: 0 !important;
        width: 48px;
        height: 48px;
        line-height: 48px;
    }

    .eskimo-advanced-search-form {
        max-width: 820px !important;
        width: 100%;
        padding: 20px;
    }

    .search-badge {
        display: inline-block;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-weight: 700;
        background: #212529;
        color: #ffffff;
        padding: 6px 14px;
        border-radius: 0 !important;
    }

    .search-headline {
        font-size: 32px;
        font-weight: 800;
        color: #212529;
        margin: 8px 0 2px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .search-subheadline {
        font-size: 14px;
        margin-bottom: 0;
    }

    /* Type Selector - Sharp Rectangular Tabs */
    .search-type-pills {
        display: inline-flex;
        background: #ffffff;
        padding: 0;
        border-radius: 0 !important;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        border: 2px solid #212529;
        flex-wrap: wrap;
        justify-content: center;
    }

    .type-pill-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 20px;
        border-radius: 0 !important;
        border: none;
        border-right: 1px solid #e9ecef;
        background: transparent;
        color: #495057;
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .type-pill-btn:last-child {
        border-right: none;
    }

    .type-pill-btn i {
        font-size: 14px;
    }

    .type-pill-btn:hover {
        background: #f1f3f5;
        color: #111;
    }

    .type-pill-btn.active {
        background: #212529 !important;
        color: #ffffff !important;
        border-radius: 0 !important;
    }

    /* Search Bar Container - Sharp Rectangular */
    .search-bar-container {
        position: relative;
    }

    .search-input-group {
        border-radius: 0 !important;
        overflow: hidden;
        background: #fff;
        border: 2px solid #212529;
        box-shadow: 0 20px 40px rgba(0,0,0,0.12) !important;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .search-input-group:focus-within {
        border-color: #f5593d;
        box-shadow: 0 20px 45px rgba(245, 89, 61, 0.2) !important;
    }

    .search-icon-prepend .input-group-text {
        background: transparent;
        border: none;
        border-radius: 0 !important;
        padding-left: 20px;
        padding-right: 10px;
        color: #868e96;
        font-size: 20px;
    }

    .search-main-input {
        border: none !important;
        border-radius: 0 !important;
        background: transparent !important;
        font-size: 18px !important;
        font-weight: 500;
        color: #212529 !important;
        height: 64px !important;
        padding: 10px 14px !important;
        box-shadow: none !important;
    }

    .search-main-input::placeholder {
        color: #adb5bd;
        font-weight: 400;
    }

    .search-clear-btn {
        background: transparent;
        border: none;
        border-radius: 0 !important;
        color: #adb5bd;
        font-size: 24px;
        line-height: 1;
        padding: 0 16px;
        cursor: pointer;
        display: none;
    }

    .search-clear-btn:hover {
        color: #495057;
    }

    .btn-search-submit {
        background: #212529;
        color: #fff;
        border: none;
        border-radius: 0 !important;
        padding: 0 32px;
        font-size: 14px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        height: 100%;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: background 0.2s ease;
    }

    .btn-search-submit:hover {
        background: #f5593d;
        color: #fff;
    }

    /* Quick Tags - Sharp Rectangular */
    .search-quick-tags {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
        gap: 8px;
    }

    .quick-tags-label {
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-right: 4px;
    }

    .quick-tag-chip {
        background: #fff;
        border: 1px solid #212529;
        border-radius: 0 !important;
        padding: 5px 14px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #212529;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .quick-tag-chip:hover {
        background: #212529;
        color: #fff;
        border-color: #212529;
    }

    .search-helper-hint kbd {
        background: #212529;
        color: #ffffff;
        font-size: 11px;
        padding: 3px 7px;
        border-radius: 0 !important;
        border: none;
    }

    @media (max-width: 768px) {
        .search-headline {
            font-size: 22px;
        }
        .search-type-pills {
            width: 100%;
        }
        .type-pill-btn {
            padding: 8px 12px;
            font-size: 11px;
            flex: 1;
            justify-content: center;
        }
        .search-main-input {
            height: 52px !important;
            font-size: 15px !important;
        }
        .btn-search-submit {
            padding: 0 18px;
            font-size: 12px;
        }
        .btn-search-submit span {
            display: none;
        }
    }
    </style>

    <!-- Search Modal Interactive JS -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('fullscreen-search-input');
        const searchTypeInput = document.getElementById('fullscreen-search-type');
        const clearBtn = document.getElementById('search-clear-input');
        const typePills = document.querySelectorAll('.type-pill-btn');
        const quickChips = document.querySelectorAll('.quick-tag-chip');
        const openSearchBtn = document.getElementById('eskimo-open-search');
        const searchModal = document.getElementById('eskimo-fullscreen-search');
        const closeSearchBtn = document.getElementById('eskimo-close-search');
        const searchForm = document.getElementById('fullscreen-search-form');

        const placeholders = {
            'all': 'Search across all collections...',
            'posts': 'Search posts, quotes, and topics...',
            'galleries': 'Search photo galleries and wallpaper collections...',
            'videos': 'Search video clips and stories...'
        };

        // Auto-focus on input when search modal is opened
        if (openSearchBtn) {
            openSearchBtn.addEventListener('click', function () {
                setTimeout(function () {
                    if (searchInput) {
                        searchInput.focus();
                        searchInput.select();
                    }
                }, 250);
            });
        }

        // Toggle Type Pills
        typePills.forEach(pill => {
            pill.addEventListener('click', function (e) {
                e.preventDefault();
                typePills.forEach(p => p.classList.remove('active'));
                this.classList.add('active');

                const chosenType = this.getAttribute('data-type') || 'all';
                if (searchTypeInput) {
                    searchTypeInput.value = chosenType;
                }
                if (searchInput && placeholders[chosenType]) {
                    searchInput.placeholder = placeholders[chosenType];
                    searchInput.focus();
                }
            });
        });

        // Quick Tag Click Handler
        quickChips.forEach(chip => {
            chip.addEventListener('click', function () {
                const keyword = this.getAttribute('data-keyword') || '';
                const chipType = this.getAttribute('data-type') || 'all';

                if (searchInput) {
                    searchInput.value = keyword;
                    clearBtn.style.display = 'block';
                }

                // Activate corresponding pill
                typePills.forEach(p => {
                    if (p.getAttribute('data-type') === chipType) {
                        p.classList.add('active');
                    } else {
                        p.classList.remove('active');
                    }
                });

                if (searchTypeInput) {
                    searchTypeInput.value = chipType;
                }

                if (searchForm) {
                    searchForm.submit();
                }
            });
        });

        // Clear input button
        if (searchInput && clearBtn) {
            searchInput.addEventListener('input', function () {
                clearBtn.style.display = this.value.length > 0 ? 'block' : 'none';
            });

            clearBtn.addEventListener('click', function () {
                searchInput.value = '';
                clearBtn.style.display = 'none';
                searchInput.focus();
            });
        }

        // Close on Escape Key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                if (searchModal && searchModal.style.display !== 'none') {
                    if (typeof $ !== 'undefined') {
                        $('#eskimo-fullscreen-search').fadeOut(200);
                    } else {
                        searchModal.style.display = 'none';
                    }
                }
            }
        });
    });
    </script>
    <!-- JS FILES -->

    @include('layouts.script')
    @yield('scripts')
</body>
</html>