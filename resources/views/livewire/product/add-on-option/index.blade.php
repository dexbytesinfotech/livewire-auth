@section('page_title')
    Product Addons Options
@endsection
<div class="container-fluid py-4" wire:init="init">
    <div class="row mt-4">
        <div class="col-12">
            <x-alert></x-alert> 
            <div class="card custom-card">
                <!-- Card header -->
                @include('livewire.product.add-on-option.filter')
                <!-- Card header end -->
            <div class="card-body pt-0">
                <x-table>

                    <x-slot name="head">
                        <x-table.heading sortable wire:click="sortBy('name')"
                            :direction="$sortField === 'name' ? $sortDirection : null"> Name
                        </x-table.heading> 
                        @if(auth()->user()->hasRole('Admin'))
                            <x-table.heading> Store Name
                            </x-table.heading> 
                        @endif
                        <x-table.heading> Addon Type
                        </x-table.heading>         
                        <x-table.heading sortable wire:click="sortBy('created_at')"
                            :direction="$sortField === 'created_at' ? $sortDirection : null">
                            Creation Date
                        </x-table.heading> 
                        <x-table.heading> Status
                        </x-table.heading>  
                        
                        <x-table.heading>
                            {{ implode(' | ',config('translatable.locales')) }}
                        </x-table.heading>                      
                        
                        
                        

                        <x-table.heading>Actions</x-table.heading>                         
                    </x-slot>
                    <x-slot name="body">
                        @foreach ($addonOptions as $addOnOption)
                        <x-table.row wire:key="row-{{  $addOnOption->id }}">
                            <x-table.cell><a href="{{ route('edit-product-addon', $addOnOption) }}">{{ $addOnOption->name }}</a></x-table.cell> 
                            @if(auth()->user()->hasRole('Admin'))
                                <x-table.cell>
                                    @if ($addOnOption->store_id)
                                        <a href="{{ route('edit-store', $addOnOption->store) }}"> {{ $addOnOption->store->name}} </a>
                                    @endif  
                                </x-table.cell>
                            @endif
                            <x-table.cell >
                                {{ $addOnOption->addon_type }}     
                             </x-table.cell>                                   
                            <x-table.cell>{{  $addOnOption->created_at }}</x-table.cell>
                            <x-table.cell> <div class="form-check form-switch ms-3">
                                 <input class="form-check-input"  wire:loading.attr="disabled"  type="checkbox" id="flexSwitchCheckDefault35"  wire:change="statusUpdate({{  $addOnOption->id }},{{ $addOnOption->status}})"
                                    @if( $addOnOption->status) checked="" @endif>
                              </div></x-table.cell> 
                              
                              <x-table.cell> 
                                @foreach (config('translatable.locales') as $locale)
                                <a href="@if(app()->getLocale() != $locale) {{ route('edit-product-addon', ['id' => $addOnOption->id,'ref_lang' => $locale]) }}  @else {{ route('edit-product-addon', $addOnOption) }} @endif" class="" data-original-title="{{ $locale }}" title="{{ $locale }}"> 
                                    <span class="material-symbols-outlined text-md">
                                     {{ in_array($locale, array_column(json_decode($addOnOption->translations, true), 'locale')) ? 'edit' : 'add' }}
                                   </span>
                                </a> 
                                @endforeach
                            </x-table.cell>

                            <x-table.cell>
                                <div class="dropdown dropup dropleft">
                                    <button class="btn bg-gradient-default" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="material-icons">
                                            more_vert
                                        </span>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        @can('edit-product-addon')
                                            <li><a class="dropdown-item"  data-original-title="Edit" title="Edit" href="{{ route('edit-product-addon', $addOnOption) }}">Edit</a></li>
                                        @endcan
                                        <li><a class="dropdown-item text-danger"  data-original-title="Remove" title="Remove" wire:click="destroyConfirm({{ $addOnOption->id }})">Delete</a></li>                                        
                                    </ul>
                                </div>                           
                            </x-table.cell>
                        </x-table.row>
                        @endforeach
                    </x-slot>
                </x-table>
                @if($addonOptions && $addonOptions->total() > 10)
                <div class="row mx-2">
                    <div class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start"><div class="dataTables_length" id="kt_ecommerce_sales_table_length">
                        <label>
                            <select  wire:model="perPage"  name="kt_ecommerce_sales_table_length" aria-controls="kt_ecommerce_sales_table" class="form-select form-select-sm form-select-solid">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </label>
                    </div>
                    </div>
                    <div class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end">
                        <div class="dataTables_paginate paging_simple_numbers" id="kt_ecommerce_sales_table_paginate">
                            @if ($addonOptions)
                            <div id="datatable-bottom">
                                {{ $addonOptions->links() }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
                @if( $addonOptions && $addonOptions->total() == 0)
                    <div>
                        <p class="text-center">No records found!</p>
                    </div>
                @endif
            </div>
            </div>
        </div>
    </div>
    <x-loder ></x-loder>
</div>
 