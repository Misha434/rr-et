resource "aws_eip" "rret-eip" {
  vpc = true
}

resource "aws_eip_association" "eip_assoc" {
  instance_id = aws_instance.rret-instance.id
  allocation_id = aws_eip.rret-eip.id
}