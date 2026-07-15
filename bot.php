$hetzner = new Hetzner(HETZNER_TOKEN);

$server = $hetzner->create(
    "Ali-01",
    "cx22",
    "ubuntu-22.04",
    "hel1"
);

$list = $hetzner->list();

$hetzner->delete($id);

$hetzner->powerOn($id);

$hetzner->powerOff($id);

$hetzner->rebuild($id);

$hetzner->resetPassword($id);
