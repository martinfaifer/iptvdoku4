<?php

namespace App\Livewire\Iptv\Channels\Tools;

use App\Models\Channel;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\AnalyzeStream;
use App\Actions\Tools\AnalyzeStreamAction;
use App\Traits\Livewire\NotificationTrait;
use App\Traits\Channels\GetAllChannelStreamsTrait;

class StreamAnalyzeComponent extends Component
{
    use GetAllChannelStreamsTrait, NotificationTrait;

    public Channel $channel;

    public array $streams = [];
    // public array $analyzedStreams = [];

    public array $sortBy = ['column' => 'created_at', 'direction' => 'desc'];

    public $analyzed;
    public bool $analyzedModal = false;

    public function mount()
    {
        $this->getAnalyzedStreams();
    }

    public function getAnalyzedStreams()
    {
        $analyzedStreams = [];
        foreach ($this->streams as $stream) {
            if (!str_contains($stream, AnalyzeStream::MULTICAST_PORT)) {
                $stream = $stream . AnalyzeStream::MULTICAST_PORT;
            }
            if (AnalyzeStream::where('stream_url', $stream)->first()) {
                foreach (AnalyzeStream::where('stream_url', $stream)->orderBy(...array_values($this->sortBy))->take(5)->get()->toArray() as $analyzed) {
                    array_push($analyzedStreams, $analyzed);
                }
            }
        }

        return array_reverse($analyzedStreams);
    }

    public function analyze($stream)
    {
        $response = (new AnalyzeStreamAction($stream))();
        if (blank($response)) {
            return $this->error_alert("Nepodařilo se provést analýzu");
        }
        $this->dispatch('refresh_analyzed_streams');
        $this->openAnalyzeModal(json_encode($response));
        return $this->success_alert("Analýza vytvořena");
    }

    public function openAnalyzeModal($analyzeStream)
    {
        $this->analyzed = json_decode($analyzeStream, true);
        return $this->analyzedModal = true;
    }

    public function closeModal()
    {
        return $this->analyzedModal = false;
    }

    #[On('refresh_analyzed_streams')]
    public function render()
    {
        $this->streams = $this->getStreams($this->channel);
        // $this->analyzedStreams = $this->getAnalyzedStreams();
        return view('livewire.iptv.channels.tools.stream-analyze-component', [
            'headers' => [
                ['key' => 'stream_url', 'label' => 'Stream', 'class' => 'text-white/80'],
                ['key' => 'created_at', 'label' => 'Vytvořeno', 'class' => 'text-white/80'],
                // ['key' => 'status', 'label' => 'Status', 'class' => 'text-white/80'],
                ['key' => 'actions', 'label' => '', 'class' => 'text-white/80'],
            ],
            'analyzedStreams' => $this->getAnalyzedStreams()
        ]);
    }
}
