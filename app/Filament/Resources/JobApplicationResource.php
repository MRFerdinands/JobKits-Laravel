<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use App\Models\JobApplication;
use Filament\Resources\Resource;
use Spatie\LaravelPdf\Enums\Unit;
use Illuminate\Support\HtmlString;
use Spatie\LaravelPdf\Facades\Pdf;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Group;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard;
use Illuminate\Support\Facades\Blade;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\SelectColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Components\ToggleButtons;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\ReplicateAction;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Tables\Actions\DeleteBulkAction;
use Dotswan\FilamentCodeEditor\Fields\CodeEditor;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\JobApplicationResource\Pages;
use Saade\FilamentAutograph\Forms\Components\SignaturePad;
use Hugomyb\FilamentMediaAction\Tables\Actions\MediaAction;
use App\Filament\Resources\JobApplicationResource\RelationManagers;
use App\Filament\Resources\JobApplicationResource\Pages\EditJobApplication;
use App\Filament\Resources\JobApplicationResource\Pages\ListJobApplications;
use App\Filament\Resources\JobApplicationResource\Pages\CreateJobApplication;
use function Spatie\LaravelPdf\Support\pdf;

class JobApplicationResource extends Resource
{
    protected static ?string $model = JobApplication::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Lamaran Pekerjaan';
    protected static ?string $modelLabel = 'Lamaran Pekerjaan';
    protected static ?string $pluralModelLabel = 'Lamaran Pekerjaan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Wizard::make([
                    Forms\Components\Wizard\Step::make('Informasi Pribadi')
                        ->schema([
                            Group::make([
                                Forms\Components\FileUpload::make('picture')
                                    ->label('Foto')
                                    ->image()
                                    ->avatar()
                                    ->imageEditor()
                                    ->disk('public')
                                    ->directory('job-applications/pictures')
                                    ->visibility('public')
                                    ->required()
                                    ->columnSpanFull(),

                                Forms\Components\TextInput::make('name')
                                    ->label('Nama Lengkap')
                                    ->placeholder('Masukkan nama lengkap Anda')
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('phone')
                                    ->label('Nomor Telepon')
                                    ->placeholder('Contoh: 08123456789')
                                    ->tel()
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('email')
                                    ->label('Email')
                                    ->placeholder('contoh@email.com')
                                    ->email()
                                    ->required()
                                    ->maxLength(255),
                            ])
                                ->columnSpan(2),
                            Group::make([
                                Group::make([
                                    Forms\Components\TextInput::make('birth_location')
                                        ->label('Tempat Lahir')
                                        ->placeholder('Kota tempat lahir')
                                        ->required()
                                        ->maxLength(255),

                                    Forms\Components\DatePicker::make('date_of_birth')
                                        ->label('Tanggal Lahir')
                                        ->placeholder('Pilih tanggal lahir')
                                        ->required()
                                        ->displayFormat('d F Y'),
                                ])
                                    ->columns(2)
                                    ->columnSpanFull(),

                                Forms\Components\Group::make([
                                    Forms\Components\TextInput::make('address.province')
                                        ->label('Provinsi')
                                        ->placeholder('Contoh: Jawa Timur')
                                        ->required(),

                                    Forms\Components\TextInput::make('address.regency')
                                        ->label('Kabupaten/Kota')
                                        ->placeholder('Contoh: Kabupaten Magetan')
                                        ->required(),

                                    Forms\Components\TextInput::make('address.district')
                                        ->label('Kecamatan')
                                        ->placeholder('Contoh: Magetan')
                                        ->required(),

                                    Forms\Components\TextInput::make('address.village')
                                        ->label('Kelurahan/Desa')
                                        ->placeholder('Contoh: Kelurahan Magetan')
                                        ->required(),

                                    Forms\Components\TextInput::make('address.rt')
                                        ->label('RT')
                                        ->placeholder('Contoh: 001')
                                        ->maxLength(3)
                                        ->required(),

                                    Forms\Components\TextInput::make('address.rw')
                                        ->label('RW')
                                        ->placeholder('Contoh: 002')
                                        ->maxLength(3)
                                        ->required(),

                                    Forms\Components\Textarea::make('address.address')
                                        ->label('Alamat Jalan')
                                        ->placeholder('Nama jalan, nomor rumah, dan detail alamat lainnya')
                                        ->required()
                                        ->rows(2)
                                        ->columnSpanFull(),
                                ])
                                    ->columns(2)
                                    ->columnSpanFull(),

                            ])
                                ->columnSpan(3),

                            RichEditor::make('summary')
                                ->label('Ringkasan Profil')
                                ->placeholder('Ceritakan tentang diri Anda, keahlian, dan pengalaman singkat')
                                ->required()
                                ->toolbarButtons([
                                    'blockquote',
                                    'bold',
                                    'bulletList',
                                    'codeBlock',
                                    'heading',
                                    'italic',
                                    'link',
                                    'orderedList',
                                    'redo',
                                    'strike',
                                    'undo',
                                ])
                                ->columnSpanFull(),

                            Forms\Components\Repeater::make('skills')
                                ->label('Keahlian')
                                ->simple(Forms\Components\TextInput::make('name')
                                    ->label('Nama Keahlian')
                                    ->placeholder('Contoh: PHP, Laravel, Photoshop')
                                    ->required())
                                ->itemLabel(fn(array $state): ?string => $state['name'] ?? null)
                                ->addActionLabel('Tambah Keahlian')
                                ->required()
                                ->collapsible()
                                ->columnSpanFull(),

                            Forms\Components\Repeater::make('extra_info')
                                ->label('Informasi Tambahan')
                                ->schema([
                                    Forms\Components\TextInput::make('name')
                                        ->label('Judul')
                                        ->placeholder('Contoh: Sertifikat, Penghargaan, Organisasi')
                                        ->required(),

                                    Forms\Components\Textarea::make('value')
                                        ->label('Deskripsi')
                                        ->placeholder('Detail informasi tambahan')
                                        ->rows(2)
                                        ->columnSpanFull(),
                                ])
                                ->itemLabel(fn(array $state): ?string => $state['title'] ?? null)
                                ->addActionLabel('Tambah Informasi')
                                ->collapsible()
                                ->columnSpanFull(),
                        ])
                        ->columns(5),
                    Forms\Components\Wizard\Step::make('Pengalaman')
                        ->schema([
                            Forms\Components\Repeater::make('experiences')
                                ->label('Pengalaman Kerja')
                                ->schema([
                                    Group::make([
                                        Select::make('start_month')
                                            ->label('Mulai pada Bulan')
                                            ->native(false)
                                            ->options([
                                                '01' => 'January',
                                                '02' => 'February',
                                                '03' => 'March',
                                                '04' => 'April',
                                                '05' => 'May',
                                                '06' => 'June',
                                                '07' => 'July',
                                                '08' => 'August',
                                                '09' => 'September',
                                                '10' => 'October',
                                                '11' => 'November',
                                                '12' => 'December',
                                            ])
                                            ->required(),
                                        Select::make('start_year')
                                            ->label('Mulai pada Tahun')
                                            ->native(false)
                                            ->options(collect(range(now()->year, 1970))->mapWithKeys(fn($y) => [$y => $y]))
                                            ->required(),
                                    ])
                                        ->columns(2)
                                        ->columnSpanFull(),

                                    Group::make([
                                        Select::make('end_month')
                                            ->label('Selesai pada Bulan')
                                            ->native(false)
                                            ->options([
                                                '01' => 'January',
                                                '02' => 'February',
                                                '03' => 'March',
                                                '04' => 'April',
                                                '05' => 'May',
                                                '06' => 'June',
                                                '07' => 'July',
                                                '08' => 'August',
                                                '09' => 'September',
                                                '10' => 'October',
                                                '11' => 'November',
                                                '12' => 'December',
                                            ])
                                            ->required(),
                                        Select::make('end_year')
                                            ->label('Selesai pada Tahun')
                                            ->native(false)
                                            ->options(collect(range(now()->year, 1970))->mapWithKeys(fn($y) => [$y => $y]))
                                            ->required(),
                                    ])
                                        ->columns(2)
                                        ->columnSpanFull(),

                                    Forms\Components\TextInput::make('position')
                                        ->label('Posisi/Jabatan')
                                        ->placeholder('Nama jabatan')
                                        ->required(),

                                    Forms\Components\TextInput::make('company')
                                        ->label('Nama Perusahaan')
                                        ->placeholder('PT. Contoh Perusahaan')
                                        ->required(),

                                    Forms\Components\Textarea::make('description')
                                        ->label('Deskripsi Pekerjaan')
                                        ->placeholder('Jelaskan tugas dan tanggung jawab Anda')
                                        ->rows(3)
                                        ->columnSpanFull(),

                                    Forms\Components\Repeater::make('jobdesk')
                                        ->label('Tugas-tugas dalam Posisi/Jabatan')
                                        ->simple(Forms\Components\TextInput::make('task')
                                            ->label('Tugas')
                                            ->placeholder('Contoh: Bersih-bersih')
                                            ->required())
                                        ->itemLabel(fn(array $state): ?string => $state['name'] ?? null)
                                        ->addActionLabel('Tambah')
                                        ->required()
                                        ->collapsible()
                                        ->columnSpanFull(),
                                ])
                                ->columns(2)
                                ->itemLabel(fn(array $state): ?string => $state['company'] ?? null)
                                ->addActionLabel('Tambah Pengalaman')
                                ->collapsible()
                                ->columnSpanFull(),
                        ]),
                    Forms\Components\Wizard\Step::make('Pendidikan')
                        ->schema([
                            Forms\Components\Repeater::make('educations')
                                ->label('Riwayat Pendidikan')
                                ->schema([
                                    Group::make([
                                        Select::make('start_year')
                                            ->label('Mulai pada Tahun')
                                            ->native(false)
                                            ->options(collect(range(now()->year, 1970))->mapWithKeys(fn($y) => [$y => $y]))
                                            ->required(),
                                        Select::make('end_year')
                                            ->label('Lulus pada Tahun')
                                            ->native(false)
                                            ->options(collect(range(now()->year, 1970))->mapWithKeys(fn($y) => [$y => $y]))
                                            ->required(),
                                    ])
                                        ->columns(2)
                                        ->columnSpanFull(),

                                    Forms\Components\TextInput::make('institution')
                                        ->label('Nama Institusi')
                                        ->placeholder('Universitas/Sekolah')
                                        ->required(),

                                    Select::make('degree')
                                        ->label('Gelar/Tingkat')
                                        ->native(false)
                                        ->options([
                                            'SD' => 'SD',
                                            'SMP' => 'SMP',
                                            'SMK' => 'SMK',
                                            'SMA' => 'SMA',
                                            'S3' => 'S3',
                                            'S2' => 'S2',
                                            'S1' => 'S1',
                                        ])
                                        ->required(),

                                    Forms\Components\TextInput::make('major')
                                        ->label('Jurusan/Program Studi')
                                        ->placeholder('Nama jurusan'),

                                    Forms\Components\Textarea::make('description')
                                        ->label('Deskripsi Pendidikan')
                                        ->placeholder('Jelaskan tugas dan tanggung jawab Anda')
                                        ->rows(3)
                                        ->columnSpanFull(),

                                    Forms\Components\Repeater::make('study_info')
                                        ->label('Apa yang anda lakukan selama Pendidikan')
                                        ->simple(Forms\Components\TextInput::make('info')
                                            ->label('Info')
                                            ->placeholder('Contoh: Belajar WEBSITE')
                                            ->required())
                                        ->itemLabel(fn(array $state): ?string => $state['name'] ?? null)
                                        ->addActionLabel('Tambah')
                                        ->collapsible()
                                        ->columnSpanFull(),
                                ])
                                ->columns(2)
                                ->itemLabel(fn(array $state): ?string => $state['institution'] ?? null)
                                ->addActionLabel('Tambah Pendidikan')
                                ->required()
                                ->collapsible()
                                ->columnSpanFull(),
                        ]),
                    Forms\Components\Wizard\Step::make('Informasi Lamaran')
                        ->schema([
                            Forms\Components\Section::make('Informasi Lamaran')
                                ->schema([
                                    Forms\Components\TextInput::make('from')
                                        ->label('Dari')
                                        ->placeholder('Sumber informasi lowongan')
                                        ->required()
                                        ->maxLength(255),

                                    Forms\Components\TextInput::make('company_name')
                                        ->label('Nama Perusahaan Tujuan')
                                        ->placeholder('PT. Perusahaan Tujuan')
                                        ->required()
                                        ->maxLength(255),

                                    Forms\Components\Textarea::make('company_address')
                                        ->label('Alamat Perusahaan')
                                        ->placeholder('Alamat lengkap perusahaan tujuan')
                                        ->required()
                                        ->rows(2)
                                        ->columnSpanFull(),

                                    Forms\Components\TextInput::make('position')
                                        ->label('Posisi yang Dilamar')
                                        ->placeholder('Nama posisi yang dilamar')
                                        ->required()
                                        ->maxLength(255),

                                    Forms\Components\Select::make('sent_type')
                                        ->label('Tipe Pengiriman')
                                        ->options([
                                            'online' => 'Online',
                                            'offline' => 'Offline',
                                        ])
                                        ->required(),

                                    SignaturePad::make('signature')
                                        ->label('Tanda Tangan')
                                        ->hint('Pastikan Tanda Tangan berada ditengah!')
                                        ->dotSize(2.0)
                                        ->lineMinWidth(0.5)
                                        ->lineMaxWidth(2.5)
                                        ->throttle(16)
                                        ->minDistance(5)
                                        ->velocityFilterWeight(0.7)
                                        ->exportPenColor('#000')
                                        ->columnSpan(1)
                                        ->required(),

                                    Forms\Components\Select::make('status')
                                        ->label('Status')
                                        ->options([
                                            'draft' => 'Draft',
                                            'sent' => 'Terkirim',
                                            'interviewed' => 'Wawancara',
                                            'rejected' => 'Ditolak',
                                            'hired' => 'Diterima',
                                        ])
                                        ->default('draft')
                                        ->required(),

                                    Forms\Components\Repeater::make('documents')
                                        ->label('Dokumen')
                                        ->schema([
                                            Forms\Components\Select::make('type')
                                                ->label('Tipe Dokumen')
                                                ->options([
                                                    'soft' => 'Soft File',
                                                    'hard' => 'Hard File',
                                                ])
                                                ->default('soft')
                                                ->live()
                                                ->native(false)
                                                ->required(),

                                            Forms\Components\TextInput::make('name')
                                                ->label('Nama Dokumen')
                                                ->placeholder('Contoh: Sertifikat, Penghargaan, Organisasi')
                                                ->required(),

                                            Forms\Components\FileUpload::make('file_path')
                                                ->label('Dokumen')
                                                ->disk('public')
                                                ->directory('job-applications/documents')
                                                ->visibility('public')
                                                ->image()
                                                ->required()
                                                ->optimize('webp')
                                                ->resize(50)
                                                ->visible(fn(Get $get) => $get('type') === 'soft')
                                                ->columnSpanFull(),
                                        ])
                                        ->itemLabel(fn(array $state): ?string => $state['name'] ?? null)
                                        ->addActionLabel('Tambah Dokumen')
                                        ->collapsed()
                                        ->columnSpanFull(),
                                ])
                                ->columns(2),
                        ]),
                ])
                    ->skippable()
                    ->persistStepInQueryString()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(false)
            ->recordAction(false)
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Perusahaan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('company_name')
                    ->label('Perusahaan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('position')
                    ->label('Posisi')
                    ->searchable(),
                TextColumn::make('sent_type')
                    ->label('Dikirim dengan')
                    ->badge()
                    ->formatStateUsing(fn($state) => match ($state) {
                        'offline' => 'Offline',
                        'online' => 'Online',
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'offline' => 'info',
                        'online' => 'warning',
                    }),
                TextColumn::make('status')
                    ->label('Tanggal dibuat')
                    ->badge()
                    ->formatStateUsing(fn($state) => match ($state) {
                        'draft' => 'Draft',
                        'sent' => 'Dikirim',
                        'interviewed' => 'Sudah Interview',
                        'rejected' => 'Ditolak',
                        'hired' => 'Diterima',
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'draft' => 'gray',
                        'sent' => 'success',
                        'interviewed' => 'warning',
                        'rejected' => 'danger',
                        'hired' => 'info',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal dibuat')
                    ->dateTime('l, d F Y. H:i'),
            ])
            ->filters([
                //
            ])
            ->actions([
                MediaAction::make('preview')
                    ->iconButton()
                    ->icon('heroicon-o-video-camera')
                    ->media(fn(JobApplication $record) => route('preview.pdf', ['data' => $record]))
                    ->modalWidth(MaxWidth::FourExtraLarge)
                    ->slideOver(),
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    // Action::make('change_send_type')
                    //     ->label('Ubah Dikirim dengan'),
                    Action::make('generate')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->label('Download')
                        ->fillForm(fn(JobApplication $record) => [
                            'filename' => Str::slug($record->name . ' ' . $record->company_name . ' ' . $record->position),
                            'border_color' => 'border-teal-500',
                            'download_option' => ['cv'],
                            'text_size' => [
                                'name_text' => 25,
                                'heading' => 14,
                                'base_heading' => 13,
                                'base' => 12,
                            ]
                        ])
                        ->form([
                            TextInput::make('filename')
                                ->label('Nama File'),
                            Select::make('border_color')
                                ->label('Border Color')
                                ->native(false)
                                ->options(function () {
                                    $colors = [
                                        'slate',
                                        'gray',
                                        'zinc',
                                        'neutral',
                                        'stone',
                                        'red',
                                        'orange',
                                        'amber',
                                        'yellow',
                                        'lime',
                                        'green',
                                        'emerald',
                                        'teal',
                                        'cyan',
                                        'sky',
                                        'blue',
                                        'indigo',
                                        'violet',
                                        'purple',
                                        'fuchsia',
                                        'pink',
                                        'rose',
                                    ];

                                    return collect($colors)
                                        ->mapWithKeys(fn($color) => [
                                            "border-{$color}-500" => "border-{$color}-500"
                                        ])
                                        ->toArray();
                                })
                                ->default('border-teal-500')
                                ->searchable(),
                            ToggleButtons::make('download_option')
                                ->label('Pilih File yang akan didownload')
                                ->multiple()
                                ->options([
                                    'cl' => 'Surat Lamaran',
                                    'cv' => 'Daftar Riwayat Hidup',
                                    'doc' => 'Lampiran'
                                ]),
                            Group::make([
                                TextInput::make('text_size.name_text')
                                    ->label('Ukuran Text Nama')
                                    ->suffix('Px')
                                    ->numeric()
                                    ->default(25)
                                    ->required(),
                                TextInput::make('text_size.heading')
                                    ->label('Ukuran Text Heading')
                                    ->suffix('Px')
                                    ->numeric()
                                    ->default(14)
                                    ->required(),
                                TextInput::make('text_size.base_heading')
                                    ->label('Ukuran Text Base Heading')
                                    ->suffix('Px')
                                    ->numeric()
                                    ->default(13)
                                    ->required(),
                                TextInput::make('text_size.base')
                                    ->label('Ukuran Text Base')
                                    ->suffix('Px')
                                    ->numeric()
                                    ->default(12)
                                    ->required(),
                            ])
                                ->columns(2)
                                ->columnSpanFull()
                        ])
                        ->action(function (JobApplication $record, array $data) {
                            $filename = $data['filename'] .  '.pdf';

                            Notification::make()
                                ->title('File telah diunduh!')
                                ->success()
                                ->send();

                            return response()->streamDownload(function () use ($record, $filename, $data) {
                                echo base64_decode(Pdf::view('templates.job-aplication', ['data' => $record, 'download_opt' => $data['download_option'], 'border_color' => $data['border_color'], 'text_size' => $data['text_size']])
                                    ->margins('25', '25', '25', '25', Unit::Pixel)
                                    ->name($filename)
                                    ->base64());
                            }, $filename);
                        })
                        ->slideOver()
                        ->modalWidth(MaxWidth::ExtraLarge),
                    ReplicateAction::make()
                        ->form([
                            Forms\Components\TextInput::make('from')
                                ->label('Dari')
                                ->placeholder('Sumber informasi lowongan')
                                ->required()
                                ->maxLength(255),

                            Forms\Components\TextInput::make('company_name')
                                ->label('Nama Perusahaan Tujuan')
                                ->placeholder('PT. Perusahaan Tujuan')
                                ->required()
                                ->maxLength(255),

                            Forms\Components\Textarea::make('company_address')
                                ->label('Alamat Perusahaan')
                                ->placeholder('Alamat lengkap perusahaan tujuan')
                                ->rows(2)
                                ->columnSpanFull(),

                            Forms\Components\TextInput::make('position')
                                ->label('Posisi yang Dilamar')
                                ->placeholder('Nama posisi yang dilamar')
                                ->required()
                                ->maxLength(255),

                            Forms\Components\Select::make('sent_type')
                                ->label('Tipe Pengiriman')
                                ->options([
                                    'online' => 'Online',
                                    'offline' => 'Offline',
                                ])
                                ->required(),
                        ])
                        ->beforeReplicaSaved(function (Model $replica, array $data): void {
                            $replica->update([
                                'from' => $data['from'],
                                'company_address' => $data['company_address'],
                                'position' => $data['position'],
                                'sent_type' => $data['sent_type'],
                                'status' => 'status',
                            ]);

                            Notification::make()
                                ->title('Data telah diduplikasi!')
                                ->success()
                                ->send();
                        }),
                    DeleteAction::make()
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJobApplications::route('/'),
            'create' => Pages\CreateJobApplication::route('/create'),
            'edit' => Pages\EditJobApplication::route('/{record}/edit'),
        ];
    }
}
