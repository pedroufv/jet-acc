<div>
    <x-jet-section-border/>

    <x-jet-form-section submit="store">
        <x-slot name="title">
            {{ __('Create Contractor') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Create a new contractor: name and identifier are mandatory.') }}
        </x-slot>

        <x-slot name="form">
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="name" value="{{ __('Name') }}"/>
                <x-jet-input id="name" type="text" class="mt-1 block w-full"
                             wire:model.defer="name" autofocus/>
                <x-jet-input-error for="name" class="mt-2"/>
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="company_name" value="{{ __('Company name') }}"/>
                <x-jet-input id="company_name" type="text" class="mt-1 block w-full"
                             wire:model.defer="company_name" autofocus/>
                <x-jet-input-error for="company_name" class="mt-2"/>
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="identifier" value="{{ __('Identificador') }}"/>
                <x-jet-input id="identifier" type="text" class="mt-1 block w-full"
                             wire:model.defer="identifier" autofocus/>
                <x-jet-input-error for="identifier" class="mt-2"/>
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="created">
                {{ __('Contractor created.') }}
            </x-jet-action-message>

            <x-jet-button>
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    </x-jet-form-section>

    @if ($this->list->isNotEmpty())
        <x-jet-section-border/>

        <div class="mt-10 sm:mt-0">
            <x-jet-action-section>
                <x-slot name="title">
                    {{ __('Contractors') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('List of all active contractors.') }}
                </x-slot>

                <x-slot name="content">
                    <div class="space-y-6">
                        @foreach ($this->list as $item)
                            <div class="flex items-center justify-between">
                                <div>
                                    {{ $item->name }}
                                </div>

                                <div>
                                    {{ $item->identifier }}
                                </div>

                                <div>
                                    {{ $item->company_name ?? 'n/a' }}
                                </div>

                                <div class="flex items-center">
                                    <button
                                        class="cursor-pointer ml-6 text-sm text-gray-400 underline focus:outline-none hover:text-teal-700"
                                        wire:click="edit({{ $item->id }})">
                                        {{ __('Edit') }}
                                    </button>

                                    <button class="cursor-pointer ml-6 text-sm text-red-500 focus:outline-none"
                                            wire:click="confirmDeletion({{ $item->id }})">
                                        {{ __('Delete') }}
                                    </button>
                                </div>
                            </div>
                        @endforeach
                        {{ $this->list->links() }}
                    </div>
                </x-slot>
            </x-jet-action-section>
        </div>
    @endif

    <x-jet-dialog-modal wire:model="managing">
        <x-slot name="title">
            {{ __('Update Contractor') }}
        </x-slot>

        <x-slot name="content">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="name" value="{{ __('Name') }}"/>
                    <x-jet-input id="name" type="text" class="mt-1 block w-full"
                                 wire:model.defer="name" autofocus/>
                    <x-jet-input-error for="name" class="mt-2"/>
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="company_name" value="{{ __('Company Name') }}"/>
                    <x-jet-input id="company_name" type="text" class="mt-1 block w-full"
                                 wire:model.defer="company_name" autofocus/>
                    <x-jet-input-error for="company_name" class="mt-2"/>
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="identifier" value="{{ __('Identificador') }}"/>
                    <x-jet-input readonly="readonly" id="identifier" type="text" class="mt-1 block w-full"
                                 wire:model.defer="identifier" autofocus/>
                    <x-jet-input-error for="identifier" class="mt-2"/>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="cancel" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="update" wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>

    <x-jet-confirmation-modal wire:model="confirmingDeletion">
        <x-slot name="title">
            {{ __('Delete Contractor') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure about it?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingDeletion')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="destroy" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>
