<div>
    <footer class="border z-footer home-footer">
        <div class="container my-0">
            <div class="row my-0">
                <div class="col-md-12 my-0">
                    <div class="inner-content text-white-50 my-0">
                        <div class="col-md-12">
                            <div class="mx-auto text-white mb-2">
                                <select wire:change="changeLocalLang" wire:model="localLang" class="form-select text-white bg-transparent" name="lang" id="lang">
                                    <option class="bg-secondary text-dark py-2" value="">@lang('lang.choose')</option>
                                    <option class="bg-secondary text-dark py-2" value="en">
                                        <span>{{trans('lang.en')}}</span>
                                    </option>
                                    <option class="bg-secondary text-dark py-2" value="fr">
                                       <span>{{trans('lang.fr')}}</span>
                                    </option>
                                </select>
                            </div>
                        </div>
                    <p>Copyright &copy; {{date('Y')}} ZtweN Oströgrasdki@webDev.
                    - Design: <a rel="nofollow noopener" href="#" target="_blank">HOUNDEKINDO</a></p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>
