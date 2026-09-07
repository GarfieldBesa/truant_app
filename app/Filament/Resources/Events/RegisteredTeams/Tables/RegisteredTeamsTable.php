<?php

namespace App\Filament\Resources\Events\RegisteredTeams\Tables;

use App\Models\EventTeam;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class RegisteredTeamsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('event.name')
                    ->label('Event')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold')
                    ->wrap(),
                TextColumn::make('team_name')
                    ->label('Team Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('team_reference')
                    ->label('Team Reference')
                    ->searchable()
                    ->badge()
                    ->color('primary')
                    ->copyable()
                    ->copyMessage('Team reference copied to clipboard'),
                TextColumn::make('created_at')
                    ->label('Registration Date')
                    ->dateTime('M d, Y h:i A')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('event_id')
                    ->label('Filter by Event')
                    ->relationship('event', 'name'),
            ])
            ->recordActions([
                ActionGroup::make([
                    Action::make('view_roster')
                        ->label('View Team Roster')
                        ->icon(Heroicon::OutlinedUserGroup)
                        ->color('info')
                        ->modalHeading(fn (EventTeam $record) => "Team Roster: {$record->team_name}")
                        ->modalDescription(fn (EventTeam $record) => "Event: {$record->event?->name} • Ref: {$record->team_reference}")
                        ->modalContent(function (EventTeam $record): HtmlString {
                            $members = $record->members;
                            if ($members->isEmpty()) {
                                return new HtmlString('<div style="padding: 16px; text-align: center; color: #64748b;">No members found in this team.</div>');
                            }

                            $html = '<div style="overflow-x: auto;"><table style="width: 100%; border-collapse: collapse; font-size: 0.875rem;">';
                            $html .= '<thead><tr style="border-bottom: 2px solid #e2e8f0; text-align: left; background: #f8fafc;">';
                            $html .= '<th style="padding: 10px 12px; color: #475569;">#</th>';
                            $html .= '<th style="padding: 10px 12px; color: #475569;">Member / Player Name</th>';
                            $html .= '<th style="padding: 10px 12px; color: #475569;">Registration Ref#</th>';
                            $html .= '<th style="padding: 10px 12px; color: #475569;">Added At</th>';
                            $html .= '</tr></thead><tbody>';

                            foreach ($members as $index => $member) {
                                $num = $index + 1;
                                $name = htmlspecialchars($member->member_name);
                                $ref = htmlspecialchars($member->registration_reference);
                                $date = $member->created_at ? $member->created_at->format('M d, Y h:i A') : '—';
                                $html .= "<tr style='border-bottom: 1px solid #f1f5f9;'>";
                                $html .= "<td style='padding: 10px 12px; color: #64748b;'>{$num}</td>";
                                $html .= "<td style='padding: 10px 12px; font-weight: 600; color: #0f172a;'>{$name}</td>";
                                $html .= "<td style='padding: 10px 12px;'><code style='background: #f1f5f9; padding: 2px 6px; border-radius: 4px; font-family: monospace;'>{$ref}</code></td>";
                                $html .= "<td style='padding: 10px 12px; color: #64748b;'>{$date}</td>";
                                $html .= '</tr>';
                            }

                            $html .= '</tbody></table></div>';
                            return new HtmlString($html);
                        })
                        ->modalSubmitAction(false),
                    DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
