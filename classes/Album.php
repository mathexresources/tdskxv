<?php

class Album
{
    private int $id;
    private string $name;
    private string $description;
    private array $texts = [];
    private string $albumPath;
    private string $coverImage;
    private string $location = "";

    private int $createdById;
    private string $createdByName;
    private string $createdDate;

    private string $createdHumanReadable;
    private bool $deleted;
    private $db;

    public function __construct($id, $db)
    {
        $this->db = $db;
        $this->id = $id;
        $sql = "SELECT * FROM albums WHERE id = $id";
        $result = $db->query($sql)->fetch_assoc();
        $this->name = $result['name'];
        $this->description = $result['description'] ?? "";
        $this->albumPath = '/img/albums/' . $id.'/';
        $this->coverImage = $result['cover_image'];
        $this->location = $result['location'] ?? "";
        $this->createdById = $result['created_by'];
        $sql = "SELECT username FROM users WHERE id = $this->createdById";
        $this->createdByName = $db->query($sql)->fetch_assoc()['username'];
        $this->createdDate = $result['created_at'];
        $this->createdHumanReadable = date('d.m.Y H:i', strtotime($result['created_at']));
        $this->deleted = $result['deleted'];
    }

    private function save()
    {
        $deleted = $this->deleted ? 1 : 0;
        $sql = "UPDATE albums SET name = '$this->name', description = '$this->description', cover_image = '$this->coverImage', location = '$this->location', deleted = '$deleted' WHERE id = $this->id";
        $this->db->query($sql);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription($length = 100): string
    {
        if (strlen($this->description) > $length) {
            return substr($this->description, 0, $length) . '...';
        }
        return $this->description;
    }

    public function getDescriptionFull(): string {
        return $this->description;
    }

    public function getTexts(): array
    {
        return $this->texts;
    }

    public function getAlbumPath(): string
    {
        return $this->albumPath;
    }

    public function getCoverImage(): string
    {
        return $this->coverImage;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function getCreatedById(): int
    {
        return $this->createdById;
    }

    public function getCreatedByName(): string
    {
        return $this->createdByName;
    }

    public function getCreatedDate(): string
    {
        return $this->createdDate;
    }

    public function getPhotos(): array
    {
        $dir = $_SERVER['DOCUMENT_ROOT'] . $this->albumPath;
        if (!is_dir($dir)) {
            return [];
        }

        $files = array_diff(scandir($dir), ['.', '..']);
        $photos = [];
        foreach ($files as $file) {
            if (is_file($dir . '/' . $file)) {
                $photos[] = $file;
            }
        }
        return $photos;
    }

    public function getPhotoCount(): int
    {
        $dir = $_SERVER['DOCUMENT_ROOT'] . $this->albumPath;

        if (!is_dir($dir)) {
            return 0;
        }

        $files = array_diff(scandir($dir), ['.', '..']);
        return count($files);
    }


    public function getCreatedHumanReadable(): string
    {
        return $this->createdHumanReadable;
    }

    public function isDeleted(): bool
    {
        return $this->deleted == 1;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
        $this->save();
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
        $this->save();
    }

    public function setTexts(array $texts): void
    {
        $this->texts = $texts;
        $this->save();
    }

    public function setCoverImage(string $coverImage): void
    {
        $this->coverImage = $coverImage;
        $this->save();
    }

    public function setLocation(string $location): void
    {
        $this->location = $location;
        $this->save();
    }

    public function setDeleted(bool $deleted): void
    {
        $this->deleted = $deleted;
        $this->save();
    }

    public function switchDeleted(): void {
        $this->deleted = !$this->deleted;
        $this->save();
    }

}
