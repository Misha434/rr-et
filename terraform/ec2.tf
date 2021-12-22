resource "aws_instance" "rret-instance" {
  ami = "ami-0218d08a1f9dac831"
  instance_type = "t2.micro"
  vpc_security_group_ids = [aws_security_group.ec2-sg.id]
  subnet_id = aws_subnet.public-subnet-1a.id
  key_name = aws_key_pair.rret-kp.key_name
  root_block_device {
    volume_type = "gp2"
    volume_size = "20"
  }
  ebs_block_device {
    device_name = "/dev/sdf"
    volume_type = "gp2"
    volume_size = "8"
  }
  tags = {
    Name = "rret-instance"
  }
}